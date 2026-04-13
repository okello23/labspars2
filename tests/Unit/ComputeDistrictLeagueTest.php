<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\LeagueDataTrait;
use Illuminate\Support\Collection;

class ComputeDistrictLeagueTest extends TestCase
{
    use LeagueDataTrait;

    /** @test */
    public function it_computes_district_league_correctly()
    {
        $data = new Collection([
            (object)[
                'district' => 'Test District',
                'region' => 'Central',
                'total_score' => 4.0,
                'facility_id' => 1,
                'created_at' => now()->subQuarter(),
            ],
            (object)[
                'district' => 'Test District',
                'region' => 'Central',
                'total_score' => 3.0,
                'facility_id' => 1,
                'created_at' => now(),
            ],
        ]);

        $result = $this->computeDistrictLeague($data);

        $this->assertTrue($result->isNotEmpty());

        $district = $result->first();
        $this->assertEquals('Test District', $district->district);
        $this->assertEquals(4.0 * 5, $district->baseline_score);
        $this->assertEquals(3.0 * 5, $district->current_score);
        $this->assertEquals((3 - 4) * 5, $district->change);
    }
}
