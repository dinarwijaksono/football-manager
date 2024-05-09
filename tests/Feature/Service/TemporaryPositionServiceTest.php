<?php

namespace Tests\Feature\Service;

use App\Models\Club;
use App\Models\Profile;
use App\Models\TemporaryPosition;
use App\Service\ClubService;
use App\Service\DivisionService;
use App\Service\TemporaryPositionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use stdClass;
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

        $this->temporaryPositionService = $this->app->make(TemporaryPositionService::class);
    }

    public function test_generate_from_club(): void
    {
        $this->temporaryPositionService->generateFromClub($this->profile->id);

        $temporaryPosition = TemporaryPosition::select('*')->get();

        $this->assertTrue($temporaryPosition->isNotEmpty());
    }

    public function test_update_draw()
    {
        $home = Club::select('*')->first();
        $away = Club::select('*')
            ->where('division_id', $home->division_id)
            ->where('id', '!=', $home->id)
            ->first();

        $data = new stdClass();
        $data->score_home = 4;
        $data->score_away = 4;
        $data->home_id = $home->id;
        $data->away_id = $away->id;

        $this->temporaryPositionService->update($data);

        $this->assertDatabaseHas('temporary_positions', [
            'club_id' => $home->id,
            'point' => 1,
            'draw' => 1,
            'number_of_match' => 1,
            'gol_in' => 4,
            'gol_out' => 4
        ]);

        $this->assertDatabaseHas('temporary_positions', [
            'club_id' => $away->id,
            'point' => 1,
            'draw' => 1,
            'number_of_match' => 1,
            'gol_in' => 4,
            'gol_out' => 4
        ]);
    }

    public function test_update_home_win()
    {
        $home = Club::select('*')->first();
        $away = Club::select('*')
            ->where('division_id', $home->division_id)
            ->where('id', '!=', $home->id)
            ->first();

        $data = new stdClass();
        $data->score_home = 4;
        $data->score_away = 2;
        $data->home_id = $home->id;
        $data->away_id = $away->id;

        $this->temporaryPositionService->update($data);

        $this->assertDatabaseHas('temporary_positions', [
            'club_id' => $home->id,
            'point' => 3,
            'win' => 1,
            'number_of_match' => 1,
            'gol_in' => 4,
            'gol_out' => 2
        ]);

        $this->assertDatabaseHas('temporary_positions', [
            'club_id' => $away->id,
            'point' => 0,
            'lost' => 1,
            'number_of_match' => 1,
            'gol_in' => 2,
            'gol_out' => 4
        ]);
    }

    public function test_update_home_lost()
    {
        $home = Club::select('*')->first();
        $away = Club::select('*')
            ->where('division_id', $home->division_id)
            ->where('id', '!=', $home->id)
            ->first();

        $data = new stdClass();
        $data->score_home = 1;
        $data->score_away = 7;
        $data->home_id = $home->id;
        $data->away_id = $away->id;

        $this->temporaryPositionService->update($data);

        $this->assertDatabaseHas('temporary_positions', [
            'club_id' => $home->id,
            'point' => 0,
            'win' => 0,
            'lost' => 1,
            'number_of_match' => 1,
            'gol_in' => 1,
            'gol_out' => 7
        ]);

        $this->assertDatabaseHas('temporary_positions', [
            'club_id' => $away->id,
            'point' => 3,
            'win' => 1,
            'number_of_match' => 1,
            'gol_in' => 7,
            'gol_out' => 1
        ]);
    }
}
