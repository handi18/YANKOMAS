<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\ActivityLog;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with(['petugas', 'layanan']);
        $user = Auth::user();

        $scope = $request->get('scope', $user->isPetugas() ? 'my_data' : 'all');

        if ($user->isPetugas() && $scope === 'my_data') {
            $query->byPetugas($user->id);
        }

        // Scope Masyarakat: tiket dari form publik yang belum memiliki petugas_id
        // (Bisa diakses oleh Admin maupun Petugas untuk sistem kolam bersama/claim)
        if ($scope === 'masyarakat') {
            $query->whereNull('petugas_id');
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->byDateRange($request->date_from, $request->date_to);
        } elseif ($request->filled('filter')) {
            match ($request->filter) {
                'today' => $query->today(),
                'week'  => $query->thisWeek(),
                'month' => $query->thisMonth(),
                'year'  => $query->thisYear(),
                default => null,
            };
        }

        if ($request->filled('jenis')) {
            $query->byJenis($request->jenis);
        }

        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('layanan_id')) {
            $query->byLayanan($request->layanan_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%$search%")
                  ->orWhere('nama_pengadu', 'like', "%$search%")
                  ->orWhere('isi_aspirasi', 'like', "%$search%")
                  ->orWhere('jenis_custom', 'like', "%$search%")
                  ->orWhere('kategori_custom', 'like', "%$search%")
                  ->orWhere('layanan_custom', 'like', "%$search%");
            });
        }

        $aspirasi = $query->orderBy('updated_at', 'desc')->paginate(15);
        $layanan = Layanan::all();

        return view('aspirasi.index', [
            'aspirasi'      => $aspirasi,
            'layanan'       => $layanan,
            'current_scope' => $scope,
        ]);
    }

    public function create()
    {
        $layanan = Layanan::all();
        return view('aspirasi.create', ['layanan' => $layanan]);
    }

    public function store(Request $request)
    {
        if ($request->jenis !== 'pengaduan' && $request->jenis !== 'custom') {
            $request->merge(['kategori' => null]);
        }

        $validated = $request->validate([
            'nama_pengadu'    => ['required', 'string', 'max:255'],
            'no_telp'         => ['nullable', 'string', 'max:20'],
            'tanggal_kejadian'=> ['required', 'date'],
            'jam_kejadian'    => ['required'],
            'jenis'           => ['required', 'in:saran,informasi,pengaduan,custom'],
            'jenis_custom'    => ['required_if:jenis,custom', 'nullable', 'string', 'max:255'],
            'kategori'        => ['required_if:jenis,pengaduan', 'nullable', 'in:ringan,sedang,berat,custom'],
            'kategori_custom' => ['required_if:kategori,custom', 'nullable', 'string', 'max:255'],
            'isi_aspirasi'    => ['required', 'string', 'min:1'],
            'layanan_id'      => ['required', function ($attribute, $value, $fail) {
                if ($value !== 'custom' && !\DB::table('layanan')->where('id', $value)->exists()) {
                    $fail('Layanan yang dipilih tidak valid.');
                }
            }],
            'layanan_custom'  => ['required_if:layanan_id,custom', 'nullable', 'string', 'max:255'],
            'media'           => ['required', 'in:Tatap Muka,Telepon,WhatsApp,Web/Online'],
        ]);

        $validated = $this->normalizeData($validated);

        // Generate nomor tiket
        $date         = date('Ymd');
        $lastAspirasi = Aspirasi::whereDate('created_at', today())->orderBy('id', 'desc')->first();
        $nextNumber   = $lastAspirasi ? ((int) substr($lastAspirasi->nomor_tiket, -4)) + 1 : 1;
        $nomor_tiket  = 'ASP-' . $date . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $validated['nomor_tiket'] = $nomor_tiket;
        $validated['petugas_id']  = Auth::id();
        $validated['status']      = 'Baru';

        Aspirasi::create($validated);

        ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Menambah aspirasi baru: ' . $nomor_tiket,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil ditambahkan.');
    }

    public function show(Aspirasi $aspirasi)
    {
        $petugasList = Auth::user()->isAdmin() ? User::where('role', 'petugas')->get() : [];
        return view('aspirasi.show', [
            'aspirasi' => $aspirasi,
            'petugasList' => $petugasList
        ]);
    }

    public function edit(Aspirasi $aspirasi)
    {
        if (Auth::user()->isPetugas() && $aspirasi->petugas_id !== Auth::id()) {
            abort(403);
        }

        $layanan = Layanan::all();
        return view('aspirasi.edit', [
            'aspirasi' => $aspirasi,
            'layanan'  => $layanan,
        ]);
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        if (Auth::user()->isPetugas() && $aspirasi->petugas_id !== Auth::id()) {
            abort(403);
        }

        if ($request->jenis !== 'pengaduan' && $request->jenis !== 'custom') {
            $request->merge(['kategori' => null]);
        }

        $rules = [
            'tanggal_kejadian'=> ['required', 'date'],
            'jam_kejadian'    => ['required'],
            'jenis'           => ['required', 'in:saran,informasi,pengaduan,custom'],
            'jenis_custom'    => ['required_if:jenis,custom', 'nullable', 'string', 'max:255'],
            'kategori'        => ['required_if:jenis,pengaduan', 'nullable', 'in:ringan,sedang,berat,custom'],
            'kategori_custom' => ['required_if:kategori,custom', 'nullable', 'string', 'max:255'],
            'isi_aspirasi'    => ['required', 'string', 'min:1'],
            'layanan_id'      => ['required', function ($attribute, $value, $fail) {
                if ($value !== 'custom' && !\DB::table('layanan')->where('id', $value)->exists()) {
                    $fail('Layanan yang dipilih tidak valid.');
                }
            }],
            'layanan_custom'  => ['required_if:layanan_id,custom', 'nullable', 'string', 'max:255'],
            'media'           => ['required', 'in:Tatap Muka,Telepon,WhatsApp,Web/Online'],
        ];

        if (Auth::user()->isAdmin()) {
            $rules['status'] = ['required', 'in:Baru,Diproses,Selesai'];
        }

        $validated = $request->validate($rules);
        $validated = $this->normalizeData($validated);

        $aspirasi->update($validated);

        ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Mengubah aspirasi: ' . $aspirasi->nomor_tiket,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $nomor_tiket = $aspirasi->nomor_tiket;
        $aspirasi->delete();

        ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Menghapus aspirasi: ' . $nomor_tiket,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        if (!Auth::user()->isAdmin() && Auth::id() !== $aspirasi->petugas_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah status data ini.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:Baru,Diproses,Selesai'],
            'jawaban' => ['nullable', 'string']
        ]);

        $aspirasi->update($validated);

        ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Mengubah status aspirasi ' . $aspirasi->nomor_tiket . ' menjadi ' . $validated['status'],
        ]);

        return redirect()->route('aspirasi.show', $aspirasi->id)->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    public function assignPetugas(Request $request, Aspirasi $aspirasi)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya Admin yang dapat menugaskan petugas.');
        }

        $validated = $request->validate([
            'petugas_id' => ['required', 'exists:users,id'],
        ]);

        $aspirasi->update(['petugas_id' => $validated['petugas_id']]);

        $petugas = User::find($validated['petugas_id']);

        ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Menugaskan tiket ' . $aspirasi->nomor_tiket . ' kepada ' . $petugas->nama,
        ]);

        return redirect()->route('aspirasi.show', $aspirasi->id)->with('success', 'Petugas berhasil ditugaskan untuk menangani laporan ini.');
    }

    public function claimPetugas(Request $request, Aspirasi $aspirasi)
    {
        // Hanya Petugas yang bisa meng-claim tiket (atau Admin yang bertindak juga sbg petugas)
        if (!is_null($aspirasi->petugas_id)) {
            return redirect()->route('aspirasi.show', $aspirasi->id)->with('error', 'Laporan ini sudah diambil alih oleh petugas lain.');
        }

        $aspirasi->update([
            'petugas_id' => Auth::id(),
            'status'     => 'Diproses' // Opsional: langsung mengubah status ke Diproses saat diclaim
        ]);

        ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Mengambil alih tiket pengaduan masyarakat: ' . $aspirasi->nomor_tiket,
        ]);

        return redirect()->route('aspirasi.show', $aspirasi->id)->with('success', 'Berhasil mengambil alih laporan. Silakan diproses!');
    }

    /**
     * Normalisasi data aspirasi sebelum disimpan ke database.
     * Menangani kasus 'custom' untuk layanan, jenis, dan kategori.
     */
    private function normalizeData(array $validated): array
    {
        // Normalisasi layanan
        if ($validated['layanan_id'] === 'custom') {
            $validated['layanan_id'] = null;
        } else {
            $validated['layanan_custom'] = null;
        }

        // Normalisasi jenis — nilai 'custom' dipetakan ke 'pengaduan' agar lolos check constraint DB
        if ($validated['jenis'] === 'custom') {
            $validated['jenis'] = 'pengaduan';
        } else {
            $validated['jenis_custom'] = null;
        }

        // Normalisasi kategori — nilai 'custom' dipetakan ke 'berat' agar lolos check constraint DB
        if (isset($validated['kategori']) && $validated['kategori'] === 'custom') {
            $validated['kategori'] = 'berat';
        } else {
            if ($validated['jenis'] !== 'pengaduan') {
                $validated['kategori'] = null;
            }
            $validated['kategori_custom'] = null;
        }

        return $validated;
    }

    /**
     * Menghapus data aspirasi yang sudah berstatus 'Selesai' (Hanya untuk Admin/Superadmin).
     */
    public function destroyAll()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk tindakan ini.');
        }

        $query = \App\Models\Aspirasi::where('status', 'Selesai');
        $total = $query->count();
        
        if ($total === 0) {
            return redirect()->route('aspirasi.index')->with('error', 'Tidak ada tiket berstatus Selesai yang dapat dihapus.');
        }
        
        // Menghapus hanya data yang selesai
        $query->delete();

        \App\Models\ActivityLog::create([
            'user_id'   => Auth::id(),
            'aktivitas' => "Membersihkan data aspirasi berstatus Selesai (Total: $total tiket).",
        ]);

        return redirect()->route('aspirasi.index')->with('success', "$total tiket yang berstatus Selesai berhasil dihapus dari sistem.");
    }
}