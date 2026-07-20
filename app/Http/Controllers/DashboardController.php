<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $sipQuery = Aspirasi::query();

        // 1. Filter Rentang Waktu (Independen: Custom Date vs Dropdown Preset)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $range = 'custom';
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay();
            $sipQuery->whereBetween('tanggal_kejadian', [$startDate, $endDate]);
        } else {
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
        $Pengaduan = (clone $sipQuery)->byJenis('pengaduan')->whereNull('jenis_custom')->count();
        $Lainnya   = (clone $sipQuery)->whereNotNull('jenis_custom')->count();

        // Grafik jenis & kategori
        $jenisSaran     = (clone $sipQuery)->byJenis('saran')->count();
        $jenisInformasi = (clone $sipQuery)->byJenis('informasi')->count();
        $jenisPengaduan = (clone $sipQuery)->byJenis('pengaduan')->whereNull('jenis_custom')->count();
        $jenisLainnya   = (clone $sipQuery)->whereNotNull('jenis_custom')->count();
        
        $kategoriRingan = (clone $sipQuery)->byKategori('ringan')->count();
        $kategoriSedang = (clone $sipQuery)->byKategori('sedang')->count();
        $kategoriBerat  = (clone $sipQuery)->byKategori('berat')->count();

        // Status
        $statusBaru     = (clone $sipQuery)->byStatus('Baru')->count();
        $statusDiproses = (clone $sipQuery)->byStatus('Diproses')->count();
        $statusSelesai  = (clone $sipQuery)->byStatus('Selesai')->count();

        // 3. Ambil Data Tren (Mendukung MySQL & Postgres secara adaptif)
        $isMysql = DB::getDriverName() === 'mysql';
        
        $dateExpression = $isMysql 
            ? "DATE_FORMAT(tanggal_kejadian, '%d %b')" 
            : "TO_CHAR(tanggal_kejadian, 'DD Mon')";

        $rawTrend = (clone $sipQuery)
            ->select(DB::raw("{$dateExpression} as date_label"), DB::raw("COUNT(*) as total"))
            ->groupBy('tanggal_kejadian', DB::raw($dateExpression))
            ->orderBy('tanggal_kejadian', 'asc')
            ->get();

        $trendData = [];
        foreach ($rawTrend as $row) {
            $trendData[] = [
                'date' => $row->date_label,
                'count' => (int) $row->total
            ];
        }

        $trendTitle = 'Tren Aspirasi (' . match($range) {
            'hari_ini'   => 'Hari Ini',
            'minggu_ini' => 'Minggu Ini',
            'bulan_ini'  => now()->translatedFormat('F Y'),
            'tahun_ini'  => 'Tahun ' . now()->year,
            'custom'     => Carbon::parse($request->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($request->end_date)->format('d/m/Y'),
            default      => 'Semua Waktu'
        } . ')';

        return view('dashboard.index', [
            'sipTotal'       => $sipTotal,
            'Saran'          => $Saran,
            'Informasi'      => $Informasi,
            'Pengaduan'      => $Pengaduan,
            'Lainnya'        => $Lainnya,
            'jenisSaran'     => $jenisSaran,
            'jenisInformasi' => $jenisInformasi,
            'jenisPengaduan' => $jenisPengaduan,
            'jenisLainnya'   => $jenisLainnya,
            'kategoriRingan' => $kategoriRingan,
            'kategoriSedang' => $kategoriSedang,
            'kategoriBerat'  => $kategoriBerat,
            'statusBaru'     => $statusBaru,
            'statusDiproses' => $statusDiproses,
            'statusSelesai'  => $statusSelesai,
            'trendData'      => json_encode($trendData),
            'trendTitle'     => $trendTitle,
            'layanan'        => $layanan,
        ]);
    }
}