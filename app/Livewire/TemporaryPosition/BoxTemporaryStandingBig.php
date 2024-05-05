<?php

namespace App\Livewire\TemporaryPosition;

use App\Models\Club;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxTemporaryStandingBig extends Component
{
    public $division;
    public $temporaryStanding;

    public function boot()
    {
        Log::withContext(['class' => BoxTemporaryStandingBig::class]);

        $club = Club::select('id', 'name', 'division_id')
            ->where('id', session()->get('club_managed_id'))
            ->first();

        $this->division = DB::table('divisions')
            ->where('id', $club->division_id)
            ->select('name')
            ->first();

        $this->temporaryStanding = DB::table('temporary_positions')
            ->join('clubs', 'clubs.id', '=', 'temporary_positions.club_id')
            ->where('temporary_positions.division_id', $club->division_id)
            ->where('temporary_positions.period', 2000)
            ->select(
                'clubs.id as club_id',
                'clubs.name as club_name',
                'temporary_positions.number_of_match',
                'temporary_positions.win',
                'temporary_positions.draw',
                'temporary_positions.lost',
                'temporary_positions.gol_in',
                'temporary_positions.gol_out',
                DB::raw('temporary_positions.gol_in - temporary_positions.gol_out as gol_difference'),
                'temporary_positions.point',
            )
            ->orderByDesc('temporary_positions.point')
            ->orderByDesc('temporary_positions.gol_in')
            ->get();
    }

    public function render()
    {
        return view('livewire.temporary-position.box-temporary-standing-big');
    }
}
