<?php

namespace App\Service;

use App\Models\Club;
use App\Models\TemporaryPosition;
use Illuminate\Support\Facades\Log;

class TemporaryPositionService
{
    public function boot()
    {
        Log::withContext(['class' => TemporaryPositionService::class]);
    }

    public function generateFromClub(int $profileId): void
    {
        try {
            self::boot();

            $clubs = Club::select('*')->where('profile_id', $profileId)->get();

            $inputData = [];
            foreach ($clubs as $key) {
                $inputData[] = [
                    'profile_id' => $profileId,
                    'division_id' => $key->division_id,
                    'period' => '2000',
                    'club_id' => $key->id,
                    'number_of_match' => 0,
                    'win' => 0,
                    'draw' => 0,
                    'lost' => 0,
                    'gol_in' => 0,
                    'gol_out' => 0,
                    'point' => 0,
                    'created_at' => round(microtime(true) * 1000),
                    'updated_at' => round(microtime(true) * 1000),
                ];
            }

            TemporaryPosition::insert($inputData);

            Log::info('Generate from clubs success');
        } catch (\Throwable $th) {
            Log::error('Generate from clubs failed', [
                'message' => $th->getMessage()
            ]);
        }
    }


    public function update(object $data): void
    {
        try {
            self::boot();

            if ($data->score_home == $data->score_away) {

                $home = TemporaryPosition::select('*')->where('club_id', $data->home_id)->first();
                TemporaryPosition::where('club_id', $data->home_id)->update([
                    'number_of_match' => $home->number_of_match + 1,
                    'draw' => $home->draw + 1,
                    'gol_in' => $home->gol_in + $data->score_home,
                    'gol_out' => $home->gol_out + $data->score_away,
                    'point' => $home->point + 1,
                    'updated_at' => round(microtime(true) * 1000),
                ]);

                $away = TemporaryPosition::select('*')->where('club_id', $data->away_id)->first();
                TemporaryPosition::where('club_id', $data->away_id)->update([
                    'number_of_match' => $away->number_of_match + 1,
                    'draw' => $away->draw + 1,
                    'gol_in' => $away->gol_in + $data->score_home,
                    'gol_out' => $away->gol_out + $data->score_away,
                    'point' => $away->point + 1,
                    'updated_at' => round(microtime(true) * 1000),
                ]);
            } elseif ($data->score_home > $data->score_away) {
                $home = TemporaryPosition::select('*')->where('club_id', $data->home_id)->first();
                TemporaryPosition::where('club_id', $data->home_id)->update([
                    'number_of_match' => $home->number_of_match + 1,
                    'win' => $home->win + 1,
                    'gol_in' => $home->gol_in + $data->score_home,
                    'gol_out' => $home->gol_out + $data->score_away,
                    'point' => $home->point + 3,
                    'updated_at' => round(microtime(true) * 1000),
                ]);

                $away = TemporaryPosition::select('*')->where('club_id', $data->away_id)->first();
                TemporaryPosition::where('club_id', $data->away_id)->update([
                    'number_of_match' => $away->number_of_match + 1,
                    'lost' => $away->lost + 1,
                    'gol_out' => $away->gol_out + $data->score_home,
                    'gol_in' => $away->gol_in + $data->score_away,
                    'updated_at' => round(microtime(true) * 1000),
                ]);
            } else {
                $home = TemporaryPosition::select('*')->where('club_id', $data->home_id)->first();
                TemporaryPosition::where('club_id', $data->home_id)->update([
                    'number_of_match' => $home->number_of_match + 1,
                    'lost' => $home->lost + 1,
                    'gol_in' => $home->gol_in + $data->score_home,
                    'gol_out' => $home->gol_out + $data->score_away,
                    'updated_at' => round(microtime(true) * 1000),
                ]);

                $away = TemporaryPosition::select('*')->where('club_id', $data->away_id)->first();
                TemporaryPosition::where('club_id', $data->away_id)->update([
                    'number_of_match' => $away->number_of_match + 1,
                    'win' => $away->win + 1,
                    'gol_out' => $away->gol_out + $data->score_home,
                    'gol_in' => $away->gol_in + $data->score_away,
                    'point' => $away->point + 3,
                    'updated_at' => round(microtime(true) * 1000),
                ]);
            }

            Log::info('update success');
        } catch (\Throwable $th) {
            Log::error('update success', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
