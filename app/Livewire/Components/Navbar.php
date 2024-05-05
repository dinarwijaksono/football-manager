<?php

namespace App\Livewire\Components;

use App\Models\DateRun;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Navbar extends Component
{
    public $date;

    public function boot()
    {
        Log::withContext(['class' => Navbar::class]);

        $this->date = DateRun::select('id', 'profile_id', 'date')
            ->where('profile_id', session()->get('profile_id'))
            ->first();
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
