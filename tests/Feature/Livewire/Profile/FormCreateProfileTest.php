<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\FormCreateProfile;
use App\Models\Club;
use App\Models\Division;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormCreateProfileTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(FormCreateProfile::class)
            ->assertStatus(200);
    }

    public function test_do_create_profile_success()
    {
        Livewire::test(FormCreateProfile::class)
            ->set('name', 'test')
            ->call('doCreateProfile')
            ->assertRedirect('/profile-select-club');

        $this->assertDatabaseHas('profiles', [
            'name' => 'test'
        ]);

        $division = Division::select('*')->get();
        $club = Club::select('*')->get();

        $this->assertTrue($division->isNotEmpty());
        $this->assertTrue($club->isNotEmpty());

        $this->assertTrue(session()->has('profile_id'));
        $this->assertTrue(session()->has('profile_name'));
    }

    public function test_do_create_profile_validate()
    {
        Livewire::test(FormCreateProfile::class)
            ->set('name', '')
            ->call('doCreateProfile')
            ->assertHasErrors('name');
    }
}
