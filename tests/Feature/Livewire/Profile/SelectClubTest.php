<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\SelectClub;
use App\Models\Club;
use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SelectClubTest extends TestCase
{
    public $profile;

    public $divisionService;
    public $clubService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);
        $this->profile = Profile::select('id', 'name', 'managed_club')->first();

        session()->put('profile_id', $this->profile->id);
        session()->put('profile_name', $this->profile->name);
    }

    public function test_renders_successfully()
    {
        Livewire::test(SelectClub::class)
            ->assertStatus(200);
    }

    public function test_do_select_club()
    {
        $club = Club::select('id', 'name')
            ->where("profile_id", $this->profile->id)
            ->first();

        Livewire::test(SelectClub::class)
            ->call('doSelectClub', $club->id);

        $this->assertDatabaseHas('profiles', [
            'id' => $this->profile->id,
            'managed_club' => $club->id,
        ]);

        $this->assertTrue(session()->has('club_managed_id'));
        $this->assertTrue(session()->has('club_managed_name'));
    }

    public function test_do_back()
    {
        Livewire::test(SelectClub::class)
            ->call('doBack');

        $this->assertTrue(session()->missing('profile_id'));
        $this->assertTrue(session()->missing('profile_name'));
    }
}
