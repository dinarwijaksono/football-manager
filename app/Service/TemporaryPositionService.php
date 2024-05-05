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
}
