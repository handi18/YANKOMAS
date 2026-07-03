<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    private function getFilteredAspirations(Request $request)
    {
        $query = Aspirasi::with(['petugas', 'layanan']);
        $user = Auth::user();

        // Ambil filter scope dari request query string (Data Saya vs Semua Data)
        // Default untuk petugas jika kosong: 'my_data'
        // Default untuk admin jika kosong: 'all'
        $scope = $request->get('scope', $user->isPetugas() ? 'my_data' : 'all');

        // Jika dia petugas dan filternya memilih 'my_data' (Data Saya), kunci hanya datanya sendiri
        if ($user->isPetugas() && $scope === 'my_data') {
            $query->byPetugas($user->id);
        }

        // Apply filters bawaan lainnya
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

        return $query->orderBy('tanggal_kejadian', 'desc')->get();
    }

    public function exportExcel(Request $request)
    {
        $aspirations = $this->getFilteredAspirations($request);

        return Excel::download(new \App\Exports\AsirasiExport($aspirations), 'aspirasi-' . now()->format('YmdHis') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $aspirations = $this->getFilteredAspirations($request);

        $data = [
            'aspirations' => $aspirations,
            'printed_by' => Auth::user()->nama,
            'printed_at' => now()->format('d-m-Y H:i:s'),
            'filter_info' => $this->getFilterInfo($request),
            'summary' => [
                'total' => $aspirations->count(),
                'saran' => $aspirations->where('jenis', 'saran')->count(),
                'informasi' => $aspirations->where('jenis', 'informasi')->count(),
                'pengaduan' => $aspirations->where('jenis', 'pengaduan')->count(),
                'ringan' => $aspirations->where('kategori', 'ringan')->count(),
                'sedang' => $aspirations->where('kategori', 'sedang')->count(),
                'berat' => $aspirations->where('kategori', 'berat')->count(),
            ]
        ];

        $pdf = Pdf::loadView('reports.pdf', $data)
                  ->setPaper('a4', 'landscape');

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Export laporan PDF',
        ]);

        return $pdf->download('laporan-aspirasi-' . now()->format('YmdHis') . '.pdf');
    }

    private function getFilterInfo(Request $request)
    {
        $info = [];
        $user = Auth::user();

        // Tambahkan informasi visibilitas data pada header keterangan filter di PDF
        $scope = $request->get('scope', $user->isPetugas() ? 'my_data' : 'all');
        if ($user->isPetugas()) {
            $info[] = 'Hak Akses: ' . ($scope === 'my_data' ? 'Data Saya' : 'Semua Data');
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $info[] = 'Periode: ' . Carbon::parse($request->date_from)->format('d/m/Y') . ' - ' . Carbon::parse($request->date_to)->format('d/m/Y');
        } elseif ($request->filled('filter')) {
            $filter = $request->filter;
            if ($filter === 'today') {
                $info[] = 'Hari ini (' . now()->format('d/m/Y') . ')';
            } elseif ($filter === 'week') {
                $info[] = 'Minggu ini';
            } elseif ($filter === 'month') {
                $info[] = 'Bulan ' . now()->format('m/Y');
            } elseif ($filter === 'year') {
                $info[] = 'Tahun ' . now()->format('Y');
            }
        }

        if ($request->filled('jenis')) {
            $info[] = 'Jenis: ' . ucfirst($request->jenis);
        }

        if ($request->filled('kategori')) {
            $info[] = 'Kategori: ' . ucfirst($request->kategori);
        }

        if ($request->filled('status')) {
            $info[] = 'Status: ' . $request->status;
        }

        return implode(', ', $info) ?: 'Semua data';
    }
}