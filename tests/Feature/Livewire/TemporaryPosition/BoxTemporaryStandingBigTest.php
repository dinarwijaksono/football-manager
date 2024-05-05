<?php

namespace Tests\Feature\Livewire\TemporaryPosition;

use App\Livewire\TemporaryPosition\BoxTemporaryStandingBig;
use App\Models\Club;
use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTemporaryStandingBigTest extends TestCase
{
    public $profile;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);
        $this->profile = Profile::select('id', 'name', 'managed_club')->first();

        session()->put('profile_id', $this->profile->id);
        session()->put('profile_name', $this->profile->name);

        $divisionService = $this->app->make(DivisionService::class);
        $divisionService->importDivisionFromCSV($this->profile->id);

        $clubService = $this->app->make(ClubService::class);
        $clubService->importClubFromCSV($this->profile->id);

        session()->put('profile_id', $this->profile->id);
        session()->put('profile_name', $this->profile->name);

        $club = Club::select('*')->first();

        session()->put('club_managed_id', $club->id);
        session()->put('club_managed_name', $club->name);
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxTemporaryStandingBig::class)
            ->assertStatus(200);
    }
}
