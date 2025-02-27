<?php

namespace App\Http\Livewire\Dashboard\Charts;

use App\Models\CaseManagement\Contact;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ContactsPieChart extends Component
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

    public function mount()
    {
        $this->updatedSelectedOption();
        $this->to_date = date('Y-m-d');
    }

    public function updatedSelectedOption()
    {

        $Data = Contact::where('lab_results', '!=', null)->where('disease_id', 1)
            ->select(DB::raw('count(id) as sample_count'), 'lab_results')->groupBy('lab_results')->get();
        $Data = Contact::where('lab_results', '!=', null)->where('disease_id', 1)
            ->selectRaw('COUNT(*) AS sample_count')
            ->selectRaw('lab_results')
            ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
            ->groupBy('lab_results')->limit(12)->get();
        dd($Data);
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
        return view('livewire.dashboard.charts.contacts-pie-chart');
    }
}
