<?php

namespace Tests\Feature;

use App\Models\Puasa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_groups_only_current_users_records_by_year(): void
    {
        $user = User::factory()->create();
        foreach ([[2025, 5, 0], [2024, 3, 3], [2025, 5, 1], [2025, 5, 1]] as [$tahun, $jumlah, $ganti]) {
            Puasa::create(['user_id' => $user->id, 'tahun' => $tahun, 'jumlah_hari' => $jumlah, 'telah_ganti' => $ganti]);
        }
        Puasa::create(['user_id' => User::factory()->create()->id, 'tahun' => 2023, 'jumlah_hari' => 20, 'telah_ganti' => 0]);

        $this->withoutVite()->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertViewHas('jumlahBaki', 3)
            ->assertViewHas('ringkasanTahunan', function ($rows) {
                return $rows->pluck('tahun')->all() === [2024, 2025]
                    && (int) $rows[0]->baki_hari === 0
                    && (int) $rows[1]->jumlah_hari === 5
                    && (int) $rows[1]->telah_ganti === 2
                    && (int) $rows[1]->baki_hari === 3;
            })
            ->assertSee('Selesai')
            ->assertSee('Belum selesai');
    }

    public function test_each_new_replacement_reduces_the_annual_balance(): void
    {
        $user = User::factory()->create();
        $this->withoutVite()->actingAs($user);

        $this->post('/puasa', ['tahun' => 2025, 'jumlah_hari' => 5, 'telah_ganti' => 0])
            ->assertSessionHasNoErrors()->assertRedirect(route('puasa.index'));
        $this->get('/dashboard')->assertOk()->assertViewHas('jumlahBaki', 5);

        foreach ([4, 3, 2, 1, 0, 0] as $baki) {
            $this->post('/puasa', ['tahun' => 2025, 'jumlah_hari' => 5, 'telah_ganti' => 1])
                ->assertSessionHasNoErrors()->assertRedirect(route('puasa.index'));
            $this->get('/dashboard')->assertOk()->assertViewHas('jumlahBaki', $baki);
        }
    }

    public function test_dashboard_shows_an_empty_state_without_records(): void
    {
        $this->withoutVite()->actingAs(User::factory()->create())->get('/dashboard')
            ->assertOk()
            ->assertViewHas('jumlahBaki', 0)
            ->assertSee('Belum ada rekod puasa.');
    }

    public function test_create_form_receives_only_the_users_annual_balances(): void
    {
        $user = User::factory()->create();
        Puasa::create(['user_id' => $user->id, 'tahun' => 2025, 'jumlah_hari' => 5, 'telah_ganti' => 1]);
        Puasa::create(['user_id' => User::factory()->create()->id, 'tahun' => 2024, 'jumlah_hari' => 9, 'telah_ganti' => 2]);

        $this->withoutVite()->actingAs($user)->get('/puasa/create')->assertOk()
            ->assertViewHas('ringkasanTahunan', fn ($rows) => $rows->count() === 1
                && (int) $rows[2025]->jumlah_asal === 5
                && (int) $rows[2025]->jumlah_ganti === 1);
    }

    public function test_recording_a_replacement_preserves_the_original_annual_total(): void
    {
        $user = User::factory()->create();
        Puasa::create(['user_id' => $user->id, 'tahun' => 2025, 'jumlah_hari' => 5, 'telah_ganti' => 1]);

        $this->withoutVite()->actingAs($user)->post('/puasa', [
            'tahun' => 2025, 'jumlah_hari' => 4, 'telah_ganti' => 1,
        ])->assertSessionHasNoErrors()->assertRedirect(route('puasa.index'));

        $this->assertSame(5, (int) Puasa::latest('id')->first()->jumlah_hari);
        $this->get('/dashboard')->assertOk()->assertViewHas('jumlahBaki', 3);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }
}
