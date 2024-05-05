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
