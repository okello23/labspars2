<?php

namespace App\Http\Controllers;

use App\Models\Microbiology\MicrobiologyAccessionedSample;
use App\Models\Microbiology\MicrobiologyAccessionIdCounter;
use App\Models\Microbiology\MicrobiologySample;
use Illuminate\Http\Request;
use Session;

class MicrobiologySamplesController extends Controller
{
    public function saveAccessionedSamples(Request $request)
    {
        if (count($_POST) <= 1) {
            return redirect()->back()->with('danger', 'No samples accessioned');
        } else {
            // code...
            \DB::transaction(function () use ($request) {
                for ($i = 0; $i < count($request->isolate_id); $i++) {

                    $sample_id = MicrobiologySample::where('isolate_id', $request->isolate_id[$i])->value('id');

                    $accessioned_sample = new MicrobiologyAccessionedSample([
                        'accession_number' => $request->accession_numbers[$i],
                        'sample_id' => $sample_id,
                        'accessioned_by' => \Auth::user()->id,
                        'date_accessioned' => date('Y-M-D H:i:s'),
                        'institution_id' => \Auth::user()->id,
                    ]);
                    $accessioned_sample->save();

                    $sample = MicrobiologySample::findOrFail($sample_id);
                    $sample->status = 3;
                    $sample->update();

                    $mcb_accession_id_counter = new MicrobiologyAccessionIdCounter([
                        'associated_locator_id' => $request->accession_numbers[$i],
                    ]);
                    $mcb_accession_id_counter->save();
                }
            });

            Session::flash('message', 'Sample(s) successfully accessioned');

            return redirect()->back();
        }
    }
}
