<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Layanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $today = Aspirasi::today()->count();
        $thisWeek = Aspirasi::thisWeek()->count();
        $thisMonth = Aspirasi::thisMonth()->count();
        $thisYear = Aspirasi::thisYear()->count();

        // Get jenis breakdown
        $jenisSaran = Aspirasi::byJenis('saran')->count();
        $jenisMasukan = Aspirasi::byJenis('masukan')->count();
        $jenisPengaduan = Aspirasi::byJenis('pengaduan')->count();

        // Get kategori breakdown
        $kategoriRingan = Aspirasi::byKategori('ringan')->count();
        $kategoriSedang = Aspirasi::byKategori('sedang')->count();
        $kategoriBerat = Aspirasi::byKategori('berat')->count();

        // Get trend data for current month
        $trendData = [];
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $daysInMonth = now()->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            $count = Aspirasi::whereDate('tanggal_kejadian', $date->format('Y-m-d'))->count();
            $trendData[] = [
                'date' => $day,
                'count' => $count
            ];
        }

        // Get top layanan
        $topLayanan = Layanan::withCount('aspirasi')
            ->orderByDesc('aspirasi_count')
            ->take(5)
            ->get();

        // Get status breakdown
        $statusBaru = Aspirasi::byStatus('Baru')->count();
        $statusDiproses = Aspirasi::byStatus('Diproses')->count();
        $statusSelesai = Aspirasi::byStatus('Selesai')->count();

        return view('dashboard.index', [
            'today' => $today,
            'thisWeek' => $thisWeek,
            'thisMonth' => $thisMonth,
            'thisYear' => $thisYear,
            'jenisSaran' => $jenisSaran,
            'jenisMasukan' => $jenisMasukan,
            'jenisPengaduan' => $jenisPengaduan,
            'kategoriRingan' => $kategoriRingan,
            'kategoriSedang' => $kategoriSedang,
            'kategoriBerat' => $kategoriBerat,
            'trendData' => json_encode($trendData),
            'topLayanan' => $topLayanan,
            'statusBaru' => $statusBaru,
            'statusDiproses' => $statusDiproses,
            'statusSelesai' => $statusSelesai,
        ]);
    }
}
