<?php

namespace App\Livewire\Components;

use App\Models\DateRun;
use App\Models\Division;
use App\Service\TimetableService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Navbar extends Component
{
    public $date;

    public function boot()
    {
        Log::withContext(['class' => Navbar::class]);

        $this->date = DateRun::select('id', 'profile_id', 'date')
            ->where('profile_id', session()->get('profile_id'))
            ->first();
    }

    public function doNextDay()
    {
        try {
            DB::beginTransaction();

            $profileId = session()->get('profile_id');

            $dateRun = DateRun::select('id', 'date')->where('profile_id', $profileId)->first();

            // make timetable
            if (date('d m', $dateRun->date) == date('d m', mktime(0, 0, 0, 1, 2, 2000))) {

                $divisions = Division::select('id', 'profile_id', 'country', 'level', 'name')
                    ->where('profile_id', $profileId)
                    ->get();

                $timetableService = App::make(TimetableService::class);
                foreach ($divisions as $key) {
                    $timetableService->generateTimetableFromCSV($profileId, $key->id);
                }
            }
            // end make timetable


            DateRun::where('profile_id', $profileId)
                ->update([
                    'date' => $dateRun->date + (24 * 60 * 60),
                    'updated_at' => round(microtime(true) * 1000)
                ]);

            Log::info('do next day success');
            DB::commit();

            return redirect('/');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('do next day failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
