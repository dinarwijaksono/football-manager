<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\BoxListProfile;
use App\Models\Club;
use App\Models\Division;
use App\Models\Profile;
use App\Models\TemporaryPosition;
use App\Service\ClubService;
use App\Service\DivisionService;
use Database\Seeders\ProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BoxListProfileTest extends TestCase
{
    public $profile;

    public $divisionService;
    public $clubService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(ProfileSeeder::class);

        $this->profile = Profile::select('*')->first();
    }

    public function test_renders_successfully()
    {
        Livewire::test(BoxListProfile::class)
            ->assertStatus(200);
    }


    public function test_do_load_profile_success_managed_null()
    {
        Livewire::test(BoxListProfile::class)
            ->call('doLoadProfile', $this->profile->id);

        $this->assertEquals($this->profile->id, session()->get('profile_id'));
        $this->assertEquals($this->profile->name, session()->get('profile_name'));

        $this->assertTrue(session()->missing('club_managed_id'));
        $this->assertTrue(session()->missing('club_managed_name'));
    }

    public function test_do_load_profile_success_managed_not_null()
    {
        $club = Club::select('id')
            ->where('profile_id', $this->profile->id)
            ->first();

        Profile::where('id', $this->profile->id)->update(['managed_club' => $club->id]);

        Livewire::test(BoxListProfile::class)
            ->call('doLoadProfile', $this->profile->id);

        $this->assertEquals($this->profile->id, session()->get('profile_id'));
        $this->assertEquals($this->profile->name, session()->get('profile_name'));

        $this->assertTrue(session()->has('club_managed_id'));
        $this->assertTrue(session()->has('club_managed_name'));
    }


    public function test_do_delete_profile()
    {
        $this->assertDatabaseHas('profiles', [
            'id' => $this->profile->id,
            'name' => $this->profile->name
        ]);

        Livewire::test(BoxListProfile::class)
            ->call('doDeleteProfile', $this->profile->id);

        $this->assertDatabaseMissing('profiles', [
            'id' => $this->profile->id,
            'name' => $this->profile->name
        ]);

        $division = Division::select('*')->get();
        $this->assertTrue($division->isEmpty());

        $club = Club::select('*')->get();
        $this->assertTrue($club->isEmpty());

        $temporaryPosition = TemporaryPosition::select('*')->get();
        $this->assertTrue($temporaryPosition->isEmpty());
    }
}
