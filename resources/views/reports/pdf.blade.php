<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #003366;
            padding-bottom: 10px;
        }
        .logo {
            width: 50px;
            height: 50px;
            margin: 0 auto 10px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 16px;
            color: #003366;
        }
        .header p {
            margin: 2px 0;
            color: #666;
        }
        .filter-info {
            background-color: #f0f0f0;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #003366;
        }
        .filter-info strong {
            color: #003366;
        }

        .summary-item:last-child {
            border-right: none;
        }
        .summary-item .value {
            font-size: 14px;
            font-weight: bold;
            color: #003366;
        }
        .summary-item .label {
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background-color: #003366;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #003366;
        }
        table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        .footer-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .footer-section {
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIMASPIRASI IMIGRASI</h1>
        <p>Sistem Informasi Saran, Informasi, dan Pengaduan Internal</p>
        <p>Kantor Imigrasi Kelas I TPI Kota Bandung</p>
    </div>

    <div class="filter-info">
        <strong>Filter:</strong> {{ $filter_info }}
    </div>

    <table style="width: 100%; background-color: #e8f4f8; margin-bottom: 15px; border-collapse: collapse;">
    <tr style="border-bottom: 1px solid #003366;">
        <td style="text-align: center; padding: 10px; border-right: 1px solid #003366;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['total'] }}</div>
            <div style="font-size: 10px; color: #666;">Total</div>
        </td>
        <td style="text-align: center; padding: 10px; border-right: 1px solid #003366;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['saran'] }}</div>
            <div style="font-size: 10px; color: #666;">Saran</div>
        </td>
        <td style="text-align: center; padding: 10px; border-right: 1px solid #003366;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['informasi'] }}</div>
            <div style="font-size: 10px; color: #666;">Informasi</div>
        </td>
        <td style="text-align: center; padding: 10px;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['pengaduan'] }}</div>
            <div style="font-size: 10px; color: #666;">Pengaduan</div>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding: 10px; border-right: 1px solid #003366;">
            <div style="font-size: 11px; color: #999;">Kategori Pengaduan</div>
        </td>
        <td style="text-align: center; padding: 10px; border-right: 1px solid #003366;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['ringan'] }}</div>
            <div style="font-size: 10px; color: #666;">Ringan</div>
        </td>
        <td style="text-align: center; padding: 10px; border-right: 1px solid #003366;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['sedang'] }}</div>
            <div style="font-size: 10px; color: #666;">Sedang</div>
        </td>
        <td style="text-align: center; padding: 10px;">
            <div style="font-size: 14px; font-weight: bold; color: #003366;">{{ $summary['berat'] }}</div>
            <div style="font-size: 10px; color: #666;">Berat</div>
        </td>
    </tr>
</table>

    <table>
        <thead>
            <tr>
                <th style="width: 15%">Nomor Tiket / Pengadu</th>
                <th style="width: 8%">Tanggal</th>
                <th style="width: 8%">Jam</th>
                <th style="width: 10%">Jenis</th>
                <th style="width: 10%">Kategori</th>
                <th style="width: 20%">Isi Aspirasi</th>
                <th style="width: 12%">Layanan</th>
                <th style="width: 8%">Media</th>
                <th style="width: 8%">Status</th>
                <th style="width: 12%">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aspirations as $item)
                <tr>
                    <td>
                        <strong>{{ $item->nama_pengadu }}</strong>
                        <div style="font-size: 9px; color: #555; margin-top: 2px;">{{ $item->nomor_tiket }}</div>
                    </td>
                    <td>{{ $item->tanggal_kejadian->format('d/m/Y') }}</td>
                    <td>{{ $item->jam_kejadian ? $item->jam_kejadian->format('H:i') : '-' }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td>{{ $item->kategori ? ucfirst($item->kategori) : '-' }}</td>
                    <td>{{ substr($item->isi_aspirasi, 0, 50) }}...</td>
                    <td>{{ $item->layanan->nama_layanan }}</td>
                    <td>{{ $item->media }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->petugas->nama }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; color: #999;">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan dihasilkan oleh SIMASPIRASI IMIGRASI</p>
        <p>Waktu cetak: {{ $printed_at }}</p>
        <div class="footer-row">
            <div class="footer-section">
                <p style="margin-bottom: 30px;">Mengetahui,</p>
                <p style="margin-bottom: 30px;">..........................</p>
                <p>Kepala Kantor</p>
            </div>
            <div class="footer-section">
                <p style="margin-bottom: 30px;">Dicetak oleh:</p>
                <p style="margin-bottom: 30px;">{{ $printed_by }}</p>
                <p>Pelapor</p>
            </div>
        </div>
    </div>
</body>
</html>