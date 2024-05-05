<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use App\Service\ClubService;
use App\Service\DivisionService;
use App\Service\TemporaryPositionService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormCreateProfile extends Component
{
    public $name;

    public function boot()
    {
        Log::withContext(['class' => FormCreateProfile::class]);
    }

    public function getRules()
    {
        return [
            'name' => 'required|max:50|unique:profiles,name'
        ];
    }

    public function doCreateProfile()
    {
        $this->validate();

        try {

            DB::beginTransaction();

            $id = DB::table('profiles')->insertGetId([
                'name' => trim($this->name),
                'managed_club' => null,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            $divisionService = App::make(DivisionService::class);
            $divisionService->importDivisionFromCSV($id);

            $clubService = App::make(ClubService::class);
            $clubService->importClubFromCSV($id);

            $temporaryPositionService = APP::make(TemporaryPositionService::class);
            $temporaryPositionService->generateFromClub($id);

            session()->put('profile_id', $id);
            session()->put('profile_name', trim($this->name));

            DB::commit();

            Log::info('do create profile success');

            return redirect('/profile-select-club');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('do create profile failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.profile.form-create-profile');
    }
}
