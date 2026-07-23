<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AsirasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithCustomStartCell, WithEvents
{
    protected $aspirations;
    protected $filterInfo;
    protected $printedAt;

    public function __construct($aspirations, $filterInfo, $printedAt)
    {
        $this->aspirations = $aspirations;
        $this->filterInfo = $filterInfo;
        $this->printedAt = $printedAt;
    }

    public function collection()
    {
        return $this->aspirations;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Nomor Tiket',
            'Nama Pengadu',
            'No Telp',
            'Tanggal',
            'Jam',
            'Jenis',
            'Kategori',
            'Isi Aspirasi',
            'Layanan',
            'Media',
            'Status',
            'Petugas',
        ];
    }

    public function map($aspirasi): array
    {
        return [
            $aspirasi->nomor_tiket,
            $aspirasi->nama_pengadu,
            $aspirasi->no_telp ?? '-',
            $aspirasi->tanggal_kejadian->format('d-m-Y'),
            $aspirasi->jam_kejadian ? $aspirasi->jam_kejadian->format('H:i') : '-',
            ucfirst($aspirasi->jenis),
            $aspirasi->kategori ? ucfirst($aspirasi->kategori) : '-',
            $aspirasi->isi_aspirasi,
            $aspirasi->layanan_id ? ($aspirasi->layanan->nama_layanan ?? '-') : ($aspirasi->layanan_custom ?? '-'),
            $aspirasi->media,
            $aspirasi->status,
            $aspirasi->petugas->nama ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Tulis filter info dan waktu cetak di baris 1
                $event->sheet->setCellValue('A1', 'Filter: ' . $this->filterInfo);
                $event->sheet->setCellValue('E1', 'Waktu Cetak: ' . $this->printedAt);
                
                // Styling text tebal untuk informasi meta
                $event->sheet->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getStyle('E1')->getFont()->setBold(true);
            },
        ];
    }
}