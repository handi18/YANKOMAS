<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Aspirasi;
use App\Models\Layanan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AsirasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_aspirasi_can_be_created(): void
    {
        $user = User::factory()->create(['role' => 'petugas']);
        $layanan = Layanan::factory()->create();

        $response = $this->actingAs($user)->post('/aspirasi', [
            'tanggal_kejadian' => now()->toDateString(),
            'jam_kejadian' => '14:30',
            'jenis' => 'pengaduan',
            'kategori' => 'sedang',
            'isi_aspirasi' => 'Ini adalah aspirasi untuk testing',
            'layanan_id' => $layanan->id,
            'media' => 'Tatap Muka',
        ]);

        $response->assertRedirect('/aspirasi');
        $this->assertDatabaseHas('aspirasi', [
            'jenis' => 'pengaduan',
            'kategori' => 'sedang',
        ]);
    }

    public function test_aspirasi_can_be_viewed(): void
    {
        $user = User::factory()->create();
        $aspirasi = Aspirasi::factory()->create();

        $response = $this->actingAs($user)->get("/aspirasi/{$aspirasi->id}");

        $response->assertStatus(200);
        $response->assertViewHas('aspirasi', $aspirasi);
    }

    public function test_aspirasi_can_be_deleted_by_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $aspirasi = Aspirasi::factory()->create();

        $response = $this->actingAs($admin)->delete("/aspirasi/{$aspirasi->id}");

        $response->assertRedirect('/aspirasi');
        $this->assertModelMissing($aspirasi);
    }
}
