<?php

namespace App\Livewire\Profile;

use App\Models\Profile;
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

            Profile::insert([
                'name' => $this->name,
                'managed_club' => null,
                'created_at' => round(microtime(true) * 1000),
                'updated_at' => round(microtime(true) * 1000),
            ]);

            session()->flash('create-profile-success', 'Profile berhasil di buat.');

            $this->name = '';

            Log::info('do create profile success');
        } catch (\Throwable $th) {
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
