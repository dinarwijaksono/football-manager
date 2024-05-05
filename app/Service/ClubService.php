<?php

namespace App\Service;

use App\Models\Club;
use App\Models\Division;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use UnexpectedValueException;

class ClubService
{
    public function boot(): void
    {
        Log::withContext(['class' => ClubService::class]);
    }

    public function importClubFromCSV(int $profileId)
    {
        try {
            self::boot();

            $file = Storage::disk('local');

            $clubs = $file->get('club/indonesia.csv');
            $clubs = explode(PHP_EOL, $clubs);

            $division = Division::select('id', 'country', 'level')
                ->where("profile_id", $profileId)
                ->get();

            $clubData = [];
            foreach ($clubs as $key) {
                if ($key == "") {
                    throw new UnexpectedValueException("Format csv tidak valid.");
                }
                $club = explode(';', $key);

                $divisionData = $division->where('country', $club[0])
                    ->where('level', $club[1])
                    ->first();

                $clubData[] = [
                    'profile_id' => $profileId,
                    'division_id' => $divisionData->id,
                    'name' => trim($club[2]),
                    'created_at' => round(microtime(true) * 1000),
                    'updated_at' => round(microtime(true) * 1000)
                ];
            }

            Club::insert($clubData);

            Log::info('import club from csv success');
        } catch (\Throwable $th) {
            Log::error('import club from csv failed.', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
