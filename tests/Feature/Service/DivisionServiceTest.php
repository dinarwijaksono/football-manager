<?php

namespace Tests\Feature\Service;

use App\Models\Division;
use App\Service\DivisionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DivisionServiceTest extends TestCase
{
    public $divisionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->divisionService = $this->app->make(DivisionService::class);
    }

    public function test_import_division_from_csv(): void
    {
        $this->divisionService->importDivisionFromCSV(1);

        $division = Division::select('*')->get();
        $this->assertTrue($division->isNotEmpty());
    }
}
