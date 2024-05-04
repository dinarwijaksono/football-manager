<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
use Livewire\Component;

class BoxListProfile extends Component
{
    public $profiles;

    public function boot()
    {
        $this->profiles = Profile::select('name', 'managed_club', 'created_at', 'updated_at')
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.profile.box-list-profile');
    }
}
