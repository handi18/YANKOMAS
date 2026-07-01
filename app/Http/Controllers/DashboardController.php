<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sipQuery = Aspirasi::query();

        // 1. Filter Rentang Waktu Global
        $range = $request->get('range', 'semua');
        switch ($range) {
            case 'hari_ini':
                $sipQuery->today();
                break;
            case 'minggu_ini':
                $sipQuery->thisWeek();
                break;
            case 'bulan_ini':
                $sipQuery->thisMonth();
                break;
            case 'tahun_ini':
                $sipQuery->thisYear();
                break;
        }

        // 2. Filter Berdasarkan Layanan
        if ($request->filled('layanan_id')) {
            $sipQuery->byLayanan($request->layanan_id);
        }

        // List layanan untuk dropdown
        $layanan = Layanan::all();

        // Stat cards
        $sipTotal  = (clone $sipQuery)->count();
        $Saran     = (clone $sipQuery)->byJenis('saran')->count();
        $Informasi = (clone $sipQuery)->byJenis('informasi')->count();
        $Pengaduan = (clone $sipQuery)->byJenis('pengaduan')->count();

        // Grafik jenis & kategori
        $jenisSaran     = (clone $sipQuery)->byJenis('saran')->count();
        $jenisPengaduan = (clone $sipQuery)->byJenis('pengaduan')->count();
        $kategoriRingan = (clone $sipQuery)->byKategori('ringan')->count();
        $kategoriSedang = (clone $sipQuery)->byKategori('sedang')->count();
        $kategoriBerat  = (clone $sipQuery)->byKategori('berat')->count();

        // Status
        $statusBaru     = (clone $sipQuery)->byStatus('Baru')->count();
        $statusDiproses = (clone $sipQuery)->byStatus('Diproses')->count();
        $statusSelesai  = (clone $sipQuery)->byStatus('Selesai')->count();

        // 3. Ambil Data Tren (Query langsung format string tgl via SQL biar kilat)
        $rawTrend = (clone $sipQuery)
            ->select(DB::raw("TO_CHAR(tanggal_kejadian, 'DD Mon') as date_label"), DB::raw("COUNT(*) as total"))
            ->groupBy(DB::raw("tanggal_kejadian, TO_CHAR(tanggal_kejadian, 'DD Mon')"))
            ->orderBy('tanggal_kejadian', 'asc')
            ->get();

        $trendData = [];
        foreach ($rawTrend as $row) {
            $trendData[] = [
                'date' => $row->date_label,
                'count' => (int) $row->total
            ];
        }

        if (empty($trendData)) {
            $trendData[] = ['date' => now()->translatedFormat('d M'), 'count' => 0];
        }

        $trendTitle = 'Tren Aspirasi (' . match($range) {
            'hari_ini'   => 'Hari Ini',
            'minggu_ini' => 'Minggu Ini',
            'bulan_ini'  => now()->translatedFormat('F Y'),
            'tahun_ini'  => 'Tahun ' . now()->year,
            default      => 'Semua Waktu'
        } . ')';

        return view('dashboard.index', [
            'sipTotal'       => $sipTotal,
            'Saran'          => $Saran,
            'Informasi'      => $Informasi,
            'Pengaduan'      => $Pengaduan,
            'jenisSaran'     => $jenisSaran,
            'jenisPengaduan' => $jenisPengaduan,
            'kategoriRingan' => $kategoriRingan,
            'kategoriSedang' => $kategoriSedang,
            'kategoriBerat'  => $kategoriBerat,
            'statusBaru'     => $statusBaru,
            'statusDiproses' => $statusDiproses,
            'statusSelesai'  => $statusSelesai,
            'trendData'      => json_encode($trendData),
            'trendTitle'     => $trendTitle,
            'layanan'        => $layanan,
            'lay'            => $layanan,
        ]);
    }
}