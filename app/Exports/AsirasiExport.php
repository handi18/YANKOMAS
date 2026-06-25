<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AsirasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $aspirations;

    public function __construct($aspirations)
    {
        $this->aspirations = $aspirations;
    }

    public function collection()
    {
        return $this->aspirations;
    }

    public function headings(): array
    {
        return [
            'Nomor Tiket',
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
            $aspirasi->tanggal_kejadian->format('d-m-Y'),
            $aspirasi->jam_kejadian->format('H:i'),
            ucfirst($aspirasi->jenis),
            ucfirst($aspirasi->kategori),
            $aspirasi->isi_aspirasi,
            $aspirasi->layanan->nama_layanan,
            $aspirasi->media,
            $aspirasi->status,
            $aspirasi->petugas->nama,
        ];
    }
}
