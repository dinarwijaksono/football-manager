<?php

namespace App\Livewire\Profile;

use App\Models\Club;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SelectClub extends Component
{
    public $clubs;

    public function boot()
    {
        Log::withContext(['class' => SelectClub::class]);

        $this->clubs = DB::table('clubs')
            ->join('divisions', 'divisions.id', '=', 'clubs.division_id')
            ->select(
                'clubs.id',
                'divisions.country',
                'divisions.name as division_name',
                'clubs.name as club_name'
            )
            ->where('clubs.profile_id', session()->get('profile_id'))
            ->orderBy('divisions.country')
            ->orderBy('divisions.level')
            ->get();
    }

    public function doSelectClub(int $clubId)
    {
        try {
            $club = Club::select('id', 'name')
                ->where('id', $clubId)
                ->first();

            Profile::where('id', session()->get('profile_id'))
                ->update([
                    'managed_club' => $club->id,
                    'updated_at' => round(microtime(true) * 1000)
                ]);

            session()->put('club_managed_id', $club->id);
            session()->put('club_managed_name', $club->name);

            Log::info('do select club success');

            return redirect('/');
        } catch (\Throwable $th) {
            Log::error('do select club failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function doBack()
    {
        session()->forget('profile_id');
        session()->forget('profile_name');

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.profile.select-club');
    }
}
