<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait VisitFiltersTrait
{
    /**
     * Apply visit filters to the Visits query builder.
     *
     * @param  Builder  $query
     * @param  array    $filters
     * @return Builder
     */
    public function scopeApplyVisitFilters(Builder $query, array $filters)
    {
        if (!empty($filters['filter_from']) && !empty($filters['filter_to'])) {
            $query->whereBetween('date_of_visit', [
                $filters['filter_from'],
                $filters['filter_to']
            ]);
        }
        if (!empty($filters['filter_facility_id'])) {
            $query->where('facility_id', $filters['filter_facility_id']);
        }
        if (!empty($filters['filter_district_id'])) {
            $query->whereHas('facility.healthSubDistrict.district', function ($f) use ($filters) {
                $f->where('id', $filters['filter_district_id']);
            });
        }
        if (!empty($filters['filter_region_id'])) {
            $query->whereHas('facility.healthSubDistrict.district', function ($d) use ($filters) {
                $d->where('region_id', $filters['filter_region_id']);
            });
        }

        return $query;
    }
}
