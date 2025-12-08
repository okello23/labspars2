<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\LeagueDataTrait;
use Illuminate\Support\Collection;

class BaselineTrendTest extends TestCase
{
    use LeagueDataTrait;

    /** @test */
    public function it_filters_last_three_months_correctly()
    {
        $data = new Collection([
            ['facility_id' => 1, 'created_at' => now()->subMonths(2), 'total_thematic' => 15],
            ['facility_id' => 1, 'created_at' => now()->subMonths(5), 'total_thematic' => 20],
        ]);

        $result = $this->getBaselineCurrentTrendLast3Months($data);

        $this->assertCount(1, $result);
    }
}
