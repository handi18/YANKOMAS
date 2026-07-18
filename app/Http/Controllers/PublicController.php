<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Layanan;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Menampilkan Landing Page Utama (Form dan Cek Status)
     */
    public function index(Request $request)
    {
        $layanan = Layanan::all();
        $aspirasiChecked = null;
        $searchPerformed = false;

        // Jika user melakukan pencarian (Cek Status)
        if ($request->filled('tiket')) {
            $searchPerformed = true;
            $aspirasiChecked = Aspirasi::where('nomor_tiket', $request->tiket)
                                ->with(['layanan', 'petugas'])
                                ->first();
        }

        return view('public.landing', [
            'layanan' => $layanan,
            'aspirasiChecked' => $aspirasiChecked,
            'searchPerformed' => $searchPerformed,
            'tiket_query' => $request->tiket ?? ''
        ]);
    }

    /**
     * Menyimpan Laporan/Aspirasi dari form publik
     */
    public function store(Request $request)
    {
        if ($request->jenis !== 'pengaduan' && $request->jenis !== 'custom') {
            $request->merge(['kategori' => null]);
        }

        $validated = $request->validate([
            'nama_pengadu'    => ['required', 'string', 'max:255'],
            'no_telp'         => ['nullable', 'string', 'max:20'],
            'tanggal_kejadian'=> ['required', 'date', 'before_or_equal:today'],
            'jam_kejadian'    => ['required'],
            'jenis'           => ['required', 'in:saran,informasi,pengaduan,custom'],
            'jenis_custom'    => ['required_if:jenis,custom', 'nullable', 'string', 'max:255'],
            'kategori'        => ['required_if:jenis,pengaduan', 'nullable', 'in:ringan,sedang,berat,custom'],
            'kategori_custom' => ['required_if:kategori,custom', 'nullable', 'string', 'max:255'],
            'isi_aspirasi'    => ['required', 'string', 'min:10'],
            'layanan_id'      => ['required', function ($attribute, $value, $fail) {
                if ($value !== 'custom' && !\DB::table('layanan')->where('id', $value)->exists()) {
                    $fail('Layanan yang dipilih tidak valid.');
                }
            }],
            'layanan_custom'  => ['required_if:layanan_id,custom', 'nullable', 'string', 'max:255'],
        ], [
            'isi_aspirasi.min' => 'Detail/Isi laporan terlalu singkat. Mohon jelaskan lebih detail (minimal 10 karakter).',
            'tanggal_kejadian.before_or_equal' => 'Tanggal kejadian tidak boleh lebih dari hari ini.'
        ]);

        $validated = $this->normalizeData($validated);

        // Generate nomor tiket
        $date         = date('Ymd');
        $lastAspirasi = Aspirasi::whereDate('created_at', today())->orderBy('id', 'desc')->first();
        $nextNumber   = $lastAspirasi ? ((int) substr($lastAspirasi->nomor_tiket, -4)) + 1 : 1;
        $nomor_tiket  = 'ASP-' . $date . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $validated['nomor_tiket'] = $nomor_tiket;
        
        // Aturan Khusus untuk Publik:
        $validated['petugas_id']  = null; 
        $validated['status']      = 'Baru';
        $validated['media']       = 'Web/Online';

        Aspirasi::create($validated);

        return redirect()->route('home')->with('success_ticket', $nomor_tiket);
    }

    /**
     * Normalisasi data (sama seperti di AspirasiController)
     */
    private function normalizeData(array $validated): array
    {
        if ($validated['layanan_id'] === 'custom') {
            $validated['layanan_id'] = null;
        } else {
            $validated['layanan_custom'] = null;
        }

        if ($validated['jenis'] === 'custom') {
            $validated['jenis'] = 'pengaduan';
        } else {
            $validated['jenis_custom'] = null;
        }

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
}
