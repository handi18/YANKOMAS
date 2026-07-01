<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\ActivityLog;
use App\Models\Layanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with(['petugas', 'layanan']);

        // Apply filters
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->byDateRange($request->date_from, $request->date_to);
        } elseif ($request->filled('filter')) {
            $filter = $request->filter;
            if ($filter === 'today') {
                $query->today();
            } elseif ($filter === 'week') {
                $query->thisWeek();
            } elseif ($filter === 'month') {
                $query->thisMonth();
            } elseif ($filter === 'year') {
                $query->thisYear();
            }
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
            $query->where(function($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%$search%")
                  ->orWhere('isi_aspirasi', 'like', "%$search%");
            });
        }

        if (Auth::user()->isPetugas()) {
            $query->byPetugas(Auth::id());
        }

        $aspirasi = $query->orderBy('updated_at', 'desc')->paginate(15);
        $layanan = Layanan::all();

        return view('aspirasi.index', [
            'aspirasi' => $aspirasi,
            'layanan' => $layanan,
        ]);
    }

    public function create()
    {
        $layanan = Layanan::all();
        return view('aspirasi.create', ['layanan' => $layanan]);
    }

    public function store(Request $request)
    {
        if ($request->jenis !== 'pengaduan') {
            $request->merge(['kategori' => null]);
        }

        $validated = $request->validate([
            'tanggal_kejadian' => ['required', 'date'],
            'jam_kejadian' => ['required', 'date_format:H:i'],
            'jenis' => ['required', 'in:saran,informasi,pengaduan'], 
            'kategori' => ['required_if:jenis,pengaduan', 'nullable', 'in:ringan,sedang,berat'],
            'isi_aspirasi' => ['required', 'string', 'min:1'],
            'layanan_id' => ['required', 'exists:layanan,id'],
            'media' => ['required', 'in:Tatap Muka,Telepon,WhatsApp'],
        ]);

        // Generate nomor tiket
        $date = date('Ymd');
        $count = Aspirasi::whereDate('created_at', today())->count() + 1;
        $nomor_tiket = 'ASP-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $validated['nomor_tiket'] = $nomor_tiket;
        $validated['petugas_id'] = Auth::id();
        $validated['status'] = 'Baru';

        Aspirasi::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menambah aspirasi baru: ' . $nomor_tiket,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil ditambahkan.');
    }

    public function show(Aspirasi $aspirasi)
    {
        // Check authorization
        if (Auth::user()->isPetugas() && $aspirasi->petugas_id !== Auth::id()) {
            abort(403);
        }

        return view('aspirasi.show', ['aspirasi' => $aspirasi]);
    }

    public function edit(Aspirasi $aspirasi)
    {
        // Check authorization
        if (Auth::user()->isPetugas() && $aspirasi->petugas_id !== Auth::id()) {
            abort(403);
        }

        $layanan = Layanan::all();
        return view('aspirasi.edit', [
            'aspirasi' => $aspirasi,
            'layanan' => $layanan,
        ]);
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        // Check authorization
        if (Auth::user()->isPetugas() && $aspirasi->petugas_id !== Auth::id()) {
            abort(403);
        }

        if ($request->jenis !== 'pengaduan') {
            $request->merge(['kategori' => null]);
        }

        $validated = $request->validate([
            'tanggal_kejadian' => ['required', 'date'],
            'jam_kejadian' => ['required', 'date_format:H:i'],
            'jenis' => ['required', 'in:saran,informasi,pengaduan'],
            'kategori' => ['required_if:jenis,pengaduan', 'nullable', 'in:ringan,sedang,berat'],
            'isi_aspirasi' => ['required', 'string', 'min:1'],
            'layanan_id' => ['required', 'exists:layanan,id'],
            'media' => ['required', 'in:Tatap Muka,Telepon,WhatsApp'],
            'status' => Auth::user()->isAdmin() ? ['required', 'in:Baru,Diproses,Selesai'] : [],
        ]);

        if (!Auth::user()->isAdmin()) {
            unset($validated['status']);
        }

        $aspirasi->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengubah aspirasi: ' . $aspirasi->nomor_tiket,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        // Only admin can delete
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $nomor_tiket = $aspirasi->nomor_tiket;
        $aspirasi->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Menghapus aspirasi: ' . $nomor_tiket,
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        // Only admin can update status
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:Baru,Diproses,Selesai'],
        ]);

        $aspirasi->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengubah status aspirasi ' . $aspirasi->nomor_tiket . ' menjadi ' . $validated['status'],
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil diperbarui.');
    }
}