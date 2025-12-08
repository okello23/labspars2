<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Collection;
use App\Exports\DistrictLeagueExport;

class DistrictLeagueExportTest extends TestCase
{
    /** @test */
    public function it_returns_correct_export_headings()
    {
        $export = new DistrictLeagueExport(new Collection());
        $this->assertEquals([
            'District',
            'Region',
            'Baseline Score',
            'Baseline Rank',
            'Change',
            '% Change',
            'Current Score',
            'Current Rank',
            'Average Score',
            'Facilities',
            'Total Visits',
        ], $export->headings());
    }

    /** @test */
    public function it_exports_correct_data_structure()
    {
        $data = new Collection([
            [
                "district" => "Kalangala",
                "region" => "Central",
                "baseline_score" => 22.1,
                "baseline_rank" => 1,
                "change" => 0,
                "percent_change" => 0,
                "current_score" => 22.1,
                "rank" => 2,
                "average_score" => 22.1,
                "facilities" => 1,
                "visits_count" => 1,
            ]
        ]);

        $export = new DistrictLeagueExport($data);

        $collection = $export->collection();

        $this->assertEquals(1, $collection->count());
        $this->assertEquals("Kalangala", $collection->first()[0]);
    }
}
