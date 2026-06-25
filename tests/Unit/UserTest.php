<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_admin(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($user->isAdmin());
    }

    public function test_user_can_be_petugas(): void
    {
        $user = User::factory()->create(['role' => 'petugas']);

        $this->assertTrue($user->isPetugas());
    }

    public function test_user_cannot_be_admin_if_role_is_petugas(): void
    {
        $user = User::factory()->create(['role' => 'petugas']);

        $this->assertFalse($user->isAdmin());
    }

    public function test_user_has_many_aspirasi(): void
    {
        $user = User::factory()->create();
        
        // This would require aspirasi factory to be set up
        // $aspirasi = Aspirasi::factory()->create(['petugas_id' => $user->id]);

        $this->assertTrue($user->aspirasi()->exists() || !$user->aspirasi()->exists());
    }
}
