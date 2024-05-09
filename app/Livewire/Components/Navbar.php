<?php

namespace App\Livewire\Components;

use App\Models\DateRun;
use App\Models\Division;
use App\Models\Timetable;
use App\Service\NextDayService;
use App\Service\TemporaryPositionService;
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

            $nextDayService = App::make(NextDayService::class);
            $nextDayService->run(session()->get('profile_id'));

            Log::info('do next day success');

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
