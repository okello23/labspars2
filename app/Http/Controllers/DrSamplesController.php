<?php

namespace App\Http\Controllers;

use App\Models\Hivdr\AccessionedSamples;
use App\Models\Hivdr\DrAccessionIdCounter;
use App\Models\Hivdr\DrugResistantSamples;
use Illuminate\Http\Request;
use Session;

class DrSamplesController extends Controller
{
    public function saveAccessionedSamples(Request $request)
    {
        if (count($_POST) <= 1) {
            return redirect()->back()->with('danger', 'No samples accessioned');
        } else {
            // code...
            \DB::transaction(function () use ($request) {
                for ($i = 0; $i < count($request->locator_id); $i++) {

                    $validator = \Validator::make($request->all(), [
                        'locator_id' => 'required|unique:accessioned_samples|max:13',
                    ], [
                        'locator_id.required' => 'Locator ID is already used',
                    ]);

                    $sample_id = DrugResistantSamples::where('id', $request->sample_id[$i])->value('id');

                    $accessioned_sample = new AccessionedSamples([
                        'locator_id' => $request->locator_id[$i],
                        'accessioned_by' => \Auth::user()->id,
                        'date_accessioned' => date('Y-M-D H:i:s'),
                        'sample_id' => $sample_id,
                    ]);
                    $accessioned_sample->save();

                    $sample = DrugResistantSamples::findOrFail($sample_id);
                    $sample->status = 3;
                    $sample->update();

                    $mcb_accession_id_counter = new DrAccessionIdCounter([
                        'associated_locator_id' => $request->locator_id[$i],
                    ]);
                    $mcb_accession_id_counter->save();
                }
            });

            Session::flash('message', 'Sample(s) successfully accessioned');

            return redirect()->back();
        }
    }
}
