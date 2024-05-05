<?php

namespace Tests\Feature\Livewire\Components;

use App\Livewire\Components\Navbar;
use App\Models\Club;
use App\Models\Profile;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);

        $profile = Profile::select('*')->first();
        session()->put('profile_id', $profile->id);
        session()->put('profile_name', $profile->name);

        $club = Club::select("*")->first();
        session()->put('club_managed_id', $club->id);
        session()->put('club_managed_name', $club->name);
    }

    public function test_renders_successfully()
    {
        Livewire::test(Navbar::class)
            ->assertStatus(200);
    }
}
