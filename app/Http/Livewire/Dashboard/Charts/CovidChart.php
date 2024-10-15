<?php

namespace App\Http\Livewire\Dashboard\Charts;

use App\Models\CaseManagement\Cases;
use Carbon\Carbon;
use Livewire\Component;

class CovidChart extends Component
{
    public $categories = [];

    public $series = [];

    public $selectedOption = null;

    public $from_date;

    public $to_date;

    public $specimen_type;

    public $pathogen_id;

    public $referral_lab_id;

    public $filter = -false;

    // protected $listeners = [
    //     'pathogenChange' => 'setPathogenId',
    //     'sampleChange' => 'setSample',
    //     'startDateChange' => 'setStartDate',
    //     'endDateChange' => 'setEndDate',
    // ];

    // public function setPathogenId($details)
    // {
    //     $this->pathogen_id = $details['pathogenId'];
    // }

    // public function setSample($details)
    // {
    //     $this->specimen_type = $details['sample'];
    // }

    public $pathogens;

    public $specimenTypes;

    public function mount()
    {
        $this->updatedSelectedOption();
        $this->to_date = date('Y-m-d');
    }

    public function updatedSelectedOption()
    {

        $Data = Cases::where('id', '!=', null)
            ->where('disease_id', 1)
            ->when($this->from_date, function ($query) {
                $from = Carbon::parse($this->from_date)->toDateTimeString();
                $to = Carbon::parse($this->to_date)->addHour(23)->addMinutes(59)->toDateTimeString();
                $query->whereBetween('lab_test_date', [$from, $to]);
            })
            ->selectRaw('COUNT(*) AS sample_count')
            ->selectRaw("DATE_FORMAT(lab_test_date, '%M-%Y') display_date")
            ->selectRaw("DATE_FORMAT(lab_test_date, '%Y-%m') new_date")
            ->groupBy('new_date')->orderBy('new_date', 'ASC')->limit(12)->get();
        // dd($Data);
        $mydata = $Data->flatten()
            ->pluck('sample_count')->toArray();
        $mycata = $Data->flatten()
            ->pluck('display_date')->toArray();
        // dd($mycata);
        $this->categories = $mycata;
        $this->series = [
            [
                'name' => 'Total Cases',
                'data' => $mydata,
            ],
        ];

        // Emit an event to update the chart
        $this->emit('updateChart', ['categories' => $this->categories, 'series' => $this->series]);
    }

    public function render()
    {
        // $data['sampleTypes'] = SampleData::where('request_no', '!=', null)->distinct()->get('specimen_type');

        return view('livewire.dashboard.charts.covid-chart');
    }
}
