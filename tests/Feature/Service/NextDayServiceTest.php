<?php

namespace Tests\Feature\Service;

use App\Models\DateRun;
use App\Models\Profile;
use App\Models\TemporaryPosition;
use App\Models\Timetable;
use App\Service\NextDayService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NextDayServiceTest extends TestCase
{
    public $nextDayService;
    public $profile;

    public function setUp(): void
    {
        parent::setUp();

        $this->nextDayService = $this->app->make(NextDayService::class);
        $this->seed(ProfileSeeder::class);

        $this->profile = Profile::select('*')->first();
    }

    public function test_next_day(): void
    {
        $this->nextDayService->run($this->profile->id);

        $date = mktime(0, 0, 0, 1, 1, 2000) + (24 * 60 * 60);
        $dateRun = DateRun::select('id', 'date')
            ->where('profile_id', $this->profile->id)
            ->first();

        $this->assertEquals($date, $dateRun->date);
    }

    public function test_generate_timetable_in_next_day_service()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->nextDayService->run($this->profile->id);
        }

        $timetable = Timetable::select('*')->where("profile_id", $this->profile->id)->get();
        $this->assertTrue($timetable->isNotEmpty());
    }

    public function test_play_game_in_next_day()
    {
        for ($i = 0; $i < 15; $i++) {
            $this->nextDayService->run($this->profile->id);
        }

        $timetable = Timetable::select('*')
            ->where('is_play', true)
            ->where('profile_id', $this->profile->id)
            ->get();
        $this->assertTrue($timetable->isNotEmpty());


        $temporaryPositions = TemporaryPosition::select('*')
            ->where('profile_id', $this->profile->id)
            ->where('number_of_match', '!=', 0)
            ->get();
        $this->assertTrue($temporaryPositions->isNotEmpty());
    }
}
