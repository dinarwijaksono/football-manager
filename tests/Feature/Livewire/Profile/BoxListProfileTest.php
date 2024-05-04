<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\BoxListProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxListProfileTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(BoxListProfile::class)
            ->assertStatus(200);
    }
}
