<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';

    protected $fillable = [
        'nomor_tiket',
        'nama_pengadu',
        'no_telp',
        'tanggal_kejadian',
        'jam_kejadian',
        'jenis',
        'kategori',
        'isi_aspirasi',
        'layanan_id',
        'media',
        'petugas_id',
        'status',
        'jenis_custom',
        'kategori_custom',
        'layanan_custom',
        'jawaban',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getJamKejadianAttribute($value): ?\Carbon\Carbon
    {
        return $value ? \Carbon\Carbon::createFromFormat('H:i:s', $value) : null;
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_kejadian', [$startDate, $endDate]);
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByLayanan($query, $layananId)
    {
        return $query->where('layanan_id', $layananId);
    }

    public function scopeByPetugas($query, $petugasId)
    {
        return $query->where('petugas_id', $petugasId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_kejadian', now()->toDateString());
    }

    public function scopeThisWeek($query)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        return $query->whereBetween('tanggal_kejadian', [$startOfWeek, $endOfWeek]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_kejadian', now()->month)
                     ->whereYear('tanggal_kejadian', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('tanggal_kejadian', now()->year);
    }
}