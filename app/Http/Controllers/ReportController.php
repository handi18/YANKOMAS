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

        return $query->orderBy('tanggal_kejadian', 'desc')->get();
    }

    public function exportExcel(Request $request)
    {
        $aspirations = $this->getFilteredAspirations($request);

        // Perbaikan: format penamaan file diubah menjadi terpisah tanda hubung
        // Hasil keluaran: aspirasi-2026-07-06-10-50-53.xlsx
        $fileName = 'aspirasi-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new \App\Exports\AsirasiExport($aspirations), $fileName);
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

        // Perbaikan: format penamaan file diubah menjadi terpisah tanda hubung
        // Hasil keluaran: laporan-aspirasi-2026-07-06-10-50-53.pdf
        $fileName = 'laporan-aspirasi-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($fileName);
    }

    private function getFilterInfo(Request $request): string
    {
        $info = [];
        $user = Auth::user();

        $scope = $request->get('scope', $user->isPetugas() ? 'my_data' : 'all');
        if ($user->isPetugas()) {
            $info[] = 'Hak Akses: ' . ($scope === 'my_data' ? 'Data Saya' : 'Semua Data');
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $info[] = 'Periode: ' . Carbon::parse($request->date_from)->format('d/m/Y') . ' - ' . Carbon::parse($request->date_to)->format('d/m/Y');
        } elseif ($request->filled('filter')) {
            $label = match ($request->filter) {
                'today' => 'Hari ini (' . now()->format('d/m/Y') . ')',
                'week'  => 'Minggu ini',
                'month' => 'Bulan ' . now()->format('m/Y'),
                'year'  => 'Tahun ' . now()->format('Y'),
                default => null,
            };
            if ($label) {
                $info[] = $label;
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