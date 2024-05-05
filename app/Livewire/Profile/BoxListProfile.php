<?php

namespace App\Livewire\Profile;

use App\Models\Club;
use App\Models\Division;
use App\Models\Profile;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class BoxListProfile extends Component
{
    public $profiles;

    public function getListeners()
    {
        return [
            'do-delete-profile' => 'render'
        ];
    }

    public function mount()
    {
        $this->profiles = Profile::select('id', 'name', 'managed_club', 'created_at', 'updated_at')
            ->orderByDesc('created_at')
            ->get();
    }

    public function booted()
    {
        Log::withContext(['class' => BoxListProfile::class]);
    }

    public function doLoadProfile(int $profileId)
    {
        try {
            $profile = Profile::select('id', 'name', 'managed_club')
                ->where('id', $profileId)
                ->first();

            session()->put('profile_id', $profile->id);
            session()->put('profile_name', $profile->name);

            if ($profile->managed_club != null) {
                $club = Club::select('id', 'name')->first();

                session()->put('club_managed_id', $club->id);
                session()->put('club_managed_name', $club->name);
            }

            return redirect('/');

            Log::info('do load profile success');
        } catch (\Throwable $th) {
            Log::error('Do Load Profile failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function doDeleteProfile(int $profileId)
    {
        try {
            Profile::where('id', $profileId)->delete();

            $this->profiles = Profile::select('id', 'name', 'managed_club', 'created_at', 'updated_at')
                ->orderByDesc('created_at')
                ->get();

            Division::where('profile_id', $profileId)->delete();
            Club::where("profile_id", $profileId)->delete();

            session()->flash('deleteSuccess', 'Profile berhasil di hapus.');
            Log::info('Do delete profile success');
        } catch (\Throwable $th) {
            Log::error('Do delete profile failed', [
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.profile.box-list-profile');
    }
}
