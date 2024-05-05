<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\BoxListProfile;
use App\Models\Club;
use App\Models\Division;
use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxListProfileTest extends TestCase
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
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxListProfile::class)
            ->assertStatus(200);
    }

    public function test_do_delete_profile()
    {
        $this->assertDatabaseHas('profiles', [
            'id' => $this->profile->id,
            'name' => $this->profile->name
        ]);

        Livewire::test(BoxListProfile::class)
            ->call('doDeleteProfile', $this->profile->id);

        $this->assertDatabaseMissing('profiles', [
            'id' => $this->profile->id,
            'name' => $this->profile->name
        ]);

        $division = Division::select('*')->get();
        $this->assertTrue($division->isEmpty());

        $club = Club::select('*')->get();
        $this->assertTrue($club->isEmpty());
    }
}
