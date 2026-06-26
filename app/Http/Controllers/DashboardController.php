<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Layanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter range waktu
        $range = $request->get('range', 'semua');
        $sipQuery = Aspirasi::query();
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
            // 'semua' = tidak ada filter tambahan
        }

        // Stat cards
        $sipTotal  = (clone $sipQuery)->count();
        $Saran     = (clone $sipQuery)->byJenis('saran')->count();
        $Informasi = (clone $sipQuery)->byJenis('informasi')->count();
        $Pengaduan = (clone $sipQuery)->byJenis('pengaduan')->count();

        // Grafik jenis (ikut filter)
        $jenisSaran     = (clone $sipQuery)->byJenis('saran')->count();
        $Informasi      = (clone $sipQuery)->byJenis('informasi')->count();
        $jenisPengaduan = (clone $sipQuery)->byJenis('pengaduan')->count();

        // Grafik kategori (ikut filter)
        $kategoriRingan = (clone $sipQuery)->byKategori('ringan')->count();
        $kategoriSedang = (clone $sipQuery)->byKategori('sedang')->count();
        $kategoriBerat  = (clone $sipQuery)->byKategori('berat')->count();

        // Status aspirasi (ikut filter)
        $statusBaru     = (clone $sipQuery)->byStatus('Baru')->count();
        $statusDiproses = (clone $sipQuery)->byStatus('Diproses')->count();
        $statusSelesai  = (clone $sipQuery)->byStatus('Selesai')->count();

        // Tren per hari dalam bulan ini (ikut filter)
        $trendData   = [];
        $currentMonth = now()->month;
        $currentYear  = now()->year;
        $daysInMonth  = now()->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date  = Carbon::create($currentYear, $currentMonth, $day);
            $count = (clone $sipQuery)->whereDate('tanggal_kejadian', $date->format('Y-m-d'))->count();
            $trendData[] = ['date' => $day, 'count' => $count];
        }

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
        ]);
    }
}