<?php

namespace App\Service;

use App\Models\Club;
use App\Models\DateRun;
use App\Models\Timetable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;

class TimetableService
{
    public function boot()
    {
        Log::withContext(['class' => TimetableService::class]);
    }

    public function generateTimetableFromCSV(int $profileId, int $divisionId)
    {
        try {
            $clubs = Club::select('id', 'name')
                ->where('profile_id', $profileId)
                ->where('division_id', $divisionId)
                ->get();

            $team = [
                'A', 'B', 'C', 'D', 'E',
                'F', 'G', 'H', 'I', 'J',
                'K', 'L', 'M', 'N', 'O',
                'P', 'Q', 'R', 'S', 'T',
            ];

            $file = Storage::disk('local');
            if ($clubs->count() == 20) {
                $file = $file->get('timetable/liga-20-team.csv');
            } elseif ($clubs->count() == 24) {
                $file = $file->get('timetable/liga-24-team.csv');

                $team[] = ['U'];
                $team[] = ['V'];
                $team[] = ['W'];
                $team[] = ['X'];
            }

            $file = explode(PHP_EOL, $file);

            $year = DateRun::select('id', 'date')->where('profile_id', $profileId)->first();
            $date = mktime(0, 0, 0, 1, 1, date('Y', $year->date));

            $timetable = [];
            foreach ($file  as $key) {
                $data = explode(';', $key);

                $timetable[] = [
                    'profile_id' => $profileId,
                    'division_id' => $divisionId,
                    'period' => date('Y', $year->date),
                    'date' => $data[2] * 24 * 60 * 60 + $date,
                    'home_id' => $clubs[array_search($data[0], $team)]->id,
                    'home_name' => $clubs[array_search($data[0], $team)]->name,
                    'away_id' => $clubs[array_search($data[1], $team)]->id,
                    'away_name' => $clubs[array_search($data[1], $team)]->name,
                    'is_play' => false,
                    'score_home' => 0,
                    'score_away' => 0,
                    'created_at' => round(microtime(true) * 1000),
                    'updated_at' => round(microtime(true) * 1000),
                ];
            }

            Timetable::insert($timetable);

            Log::info('generate timetable from csv success');
        } catch (\Throwable $th) {
            Log::error('generate timetable from csv failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function playMatch(int $timetableId)
    {
        try {
            self::boot();

            Timetable::where('id', $timetableId)->update([
                'is_play' => true,
                'score_home' => random_int(0, 10),
                'score_away' => random_int(0, 10),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            Log::info('play match success');
        } catch (\Throwable $th) {
            Log::error('play match failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
