<?php

namespace Tests\Feature\Service;

use App\Models\Profile;
use App\Models\TemporaryPosition;
use App\Service\ClubService;
use App\Service\DivisionService;
use App\Service\TemporaryPositionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TemporaryPositionServiceTest extends TestCase
{
    public $profile;
    public $temporaryPositionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);
        $this->profile = Profile::select('*')->first();

        $divisionService = $this->app->make(DivisionService::class);
        $divisionService->importDivisionFromCSV($this->profile->id);

        $clubService = $this->app->make(ClubService::class);
        $clubService->importClubFromCSV($this->profile->id);

        $this->temporaryPositionService = $this->app->make(TemporaryPositionService::class);
    }

    public function test_generate_from_club(): void
    {
        $this->temporaryPositionService->generateFromClub($this->profile->id);

        $temporaryPosition = TemporaryPosition::select('*')->get();

        $this->assertTrue($temporaryPosition->isNotEmpty());
    }
}
