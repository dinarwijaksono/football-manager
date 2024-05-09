<?php

namespace App\Service;

use App\Models\DateRun;
use App\Models\Division;
use App\Models\Timetable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NextDayService
{
    public $timetableService;
    public $temporaryPositionService;

    public function __construct(TimetableService $timetableService, TemporaryPositionService $temporaryPositionService)
    {
        $this->timetableService = $timetableService;
        $this->temporaryPositionService = $temporaryPositionService;
    }

    public function boot()
    {
        Log::withContext(['class' => NextDayService::class]);
    }

    public function run(int $profileId)
    {
        try {
            self::boot();

            DB::beginTransaction();

            $dateRun = DateRun::select('id', 'date')->where('profile_id', $profileId)->first();

            // make timetable
            if (date('d m', $dateRun->date) == date('d m', mktime(0, 0, 0, 1, 2, 2000))) {

                $divisions = Division::select('id', 'profile_id', 'country', 'level', 'name')
                    ->where('profile_id', $profileId)
                    ->get();

                foreach ($divisions as $key) {
                    $this->timetableService->generateTimetableFromCSV($profileId, $key->id);
                }
            }
            // end make timetable

            // play match
            $timetableId = Timetable::select('id')->where('date', $dateRun->date)->get();

            foreach ($timetableId as $key) {
                $this->timetableService->playMatch($key->id);

                $dataInsert = Timetable::select(
                    'id',
                    'home_id',
                    'score_home',
                    'away_id',
                    'score_away'
                )->where('id', $key->id)
                    ->first();

                $this->temporaryPositionService->update($dataInsert);
            }
            // end play match

            DateRun::where('profile_id', $profileId)
                ->update([
                    'date' => $dateRun->date + (24 * 60 * 60),
                    'updated_at' => round(microtime(true) * 1000)
                ]);

            DB::commit();
            Log::info('Next day success');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Next day failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
