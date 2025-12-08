<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Livewire\Reports\LeagueTableComponent;
use App\Exports\DistrictLeagueExport;

class LeagueTableComponentTest extends TestCase
{
    /** @test */
    public function it_triggers_export()
    {
        Excel::fake();

        Livewire::test(LeagueTableComponent::class)
            ->call('export');

        Excel::assertDownloaded('district_league.xlsx', function (DistrictLeagueExport $export) {
            return true;
        });
    }
}
