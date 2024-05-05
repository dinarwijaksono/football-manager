<?php

namespace App\Service;

use App\Models\Division;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class DivisionService
{
    public function boot(): void
    {
        Log::withContext(['class' => DivisionService::class]);
    }

    public function importDivisionFromCSV(int $profileId): void
    {
        try {
            self::boot();

            $file = Storage::disk('local');

            $divisions = $file->get('division/indonesia.csv');
            $divisions = explode(PHP_EOL, $divisions);

            $divisionData = [];
            foreach ($divisions as $key) {
                $division = explode(';', $key);

                $divisionData[] = [
                    'profile_id' => $profileId,
                    'country' => $division[0],
                    'level' => $division[1],
                    'name' => trim($division[2]),
                    'created_at' => round(microtime(true) * 1000),
                    'updated_at' => round(microtime(true) * 1000)
                ];
            }

            Division::insert($divisionData);

            Log::info('import division from csv success');
        } catch (\Throwable $th) {
            Log::error('import division from csv failed', [
                'message' => $th->getMessage()
            ]);
        }
    }
}
