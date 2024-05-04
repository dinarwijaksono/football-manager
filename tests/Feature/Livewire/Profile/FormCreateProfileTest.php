<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\FormCreateProfile;
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
            ->call('doCreateProfile');

        $this->assertDatabaseHas('profiles', [
            'name' => 'test'
        ]);
    }

    public function test_do_create_profile_validate()
    {
        Livewire::test(FormCreateProfile::class)
            ->set('name', '')
            ->call('doCreateProfile')
            ->assertHasErrors('name');
    }
}
