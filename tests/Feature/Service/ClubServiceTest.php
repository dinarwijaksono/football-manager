<?php

namespace Tests\Feature\Service;

use App\Models\Club;
use App\Models\Division;
use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClubServiceTest extends TestCase
{
    public $clubService;

    public $profile;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);
        $this->profile = Profile::select('*')->first();

        $this->clubService = $this->app->make(ClubService::class);
    }

    public function test_import_club_from_csv(): void
    {
        $this->clubService->importClubFromCSV($this->profile->id);

        $clubs = Club::select('*')->get();

        $this->assertTrue($clubs->isNotEmpty());
    }
}
