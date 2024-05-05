<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\BoxListProfile;
use App\Models\Profile;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxListProfileTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(BoxListProfile::class)
            ->assertStatus(200);
    }

    public function test_do_delete_profile()
    {
        $this->seed(ProfileSeeder::class);

        $profile = Profile::select('*')->first();

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'name' => $profile->name
        ]);

        Livewire::test(BoxListProfile::class)
            ->call('doDeleteProfile', $profile->id);

        $this->assertDatabaseMissing('profiles', [
            'id' => $profile->id,
            'name' => $profile->name
        ]);
    }
}
