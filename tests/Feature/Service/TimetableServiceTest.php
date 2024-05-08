<?php

namespace Tests\Feature\Service;

use App\Models\Club;
use App\Models\DateRun;
use App\Models\Division;
use App\Models\Profile;
use App\Models\Timetable;
use App\Service\TimetableService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimetableServiceTest extends TestCase
{
    public $profile;
    public $timetableService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);

        $this->timetableService = $this->app->make(TimetableService::class);

        $this->profile = Profile::select('*')->first();
        session()->put('profile_id', $this->profile->id);
        session()->put('profile_name', $this->profile->name);

        $club = Club::select('*')->first();
        session()->put('club_managed_id', $club->id);
        session()->put('club_managed_name', $club->name);
    }

    public function test_generate_timetable_from_csv(): void
    {
        $division = Division::select('*')->where('level', 2)->first();

        $this->timetableService->generateTimetableFromCsv($this->profile->id, $division->id);

        $timetable = Timetable::select('*')->get();
        $this->assertTrue($timetable->isNotEmpty());
    }
}
