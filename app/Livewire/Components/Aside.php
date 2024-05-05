<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Aside extends Component
{
    public function doLogout()
    {
        session()->forget('profile_id');
        session()->forget('profile_name');

        session()->forget('club_managed_id');
        session()->forget('club_managed_name');

        return redirect('/profile');
    }

    public function render()
    {
        return view('livewire.components.aside');
    }
}
