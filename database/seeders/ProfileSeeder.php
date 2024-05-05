<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use App\Service\TemporaryPositionService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = 'test' . random_int(1, 9999);

        Profile::insert([
            'name' => $name,
            'managed_club' => null,
            'created_at' => round(microtime(true) * 100),
            'updated_at' => round(microtime(true) * 100),
        ]);

        $profile = Profile::select('*')->first();

        $divisionService = App::make(DivisionService::class);
        $divisionService->importDivisionFromCSV($profile->id);

        $clubService = App::make(ClubService::class);
        $clubService->importClubFromCSV($profile->id);

        $temporaryPositionService = App::make(TemporaryPositionService::class);
        $temporaryPositionService->generateFromClub($profile->id);
    }
}
