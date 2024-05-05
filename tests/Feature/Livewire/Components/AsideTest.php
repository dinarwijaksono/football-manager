<?php

namespace Tests\Feature\Livewire\Components;

use App\Livewire\Components\Aside;
use App\Models\Club;
use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AsideTest extends TestCase
{
    public $profile;

    public $divisionService;
    public $clubService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);

        $this->profile = Profile::select('*')->first();

        $this->divisionService = $this->app->make(DivisionService::class);
        $this->divisionService->importDivisionFromCSV($this->profile->id);

        $this->clubService = $this->app->make(ClubService::class);
        $this->clubService->importClubFromCSV($this->profile->id);

        $club = Club::select('*')->where("profile_id", $this->profile->id)->first();
        Profile::where('id', $this->profile->id)->update(['managed_club' => $club->id]);

        $this->clubService = $this->app->make(ClubService::class);
        $this->clubService->importClubFromCSV($this->profile->id);

        session()->put('profile_id', $this->profile->id);
        session()->put('profile_name', $this->profile->name);

        session()->put('club_managed_id', $club->id);
        session()->put('club_managed_name', $club->name);
    }

    public function test_renders_successfully()
    {
        Livewire::test(Aside::class)
            ->assertStatus(200);
    }


    public function test_do_logout()
    {
        Livewire::test(Aside::class)
            ->call('doLogout');

        $this->assertTrue(session()->missing('profile_id'));
        $this->assertTrue(session()->missing('profile_name'));

        $this->assertTrue(session()->missing('club_managed_id'));
        $this->assertTrue(session()->missing('club_managed_name'));
    }
}
