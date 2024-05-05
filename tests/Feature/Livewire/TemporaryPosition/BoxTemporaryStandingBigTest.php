<?php

namespace Tests\Feature\Livewire\TemporaryPosition;

use App\Livewire\TemporaryPosition\BoxTemporaryStandingBig;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxTemporaryStandingBigTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(BoxTemporaryStandingBig::class)
            ->assertStatus(200);
    }
}
