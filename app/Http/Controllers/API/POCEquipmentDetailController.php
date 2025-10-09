<?php

namespace App\Http\Controllers\API;

use App\Models\PocEquipmentDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class POCEquipmentDetailController extends Controller
{
    //
    public function store(Request $request)
    {
        

        try {
            $validatedData = $request->validate([
            'test_date' => 'required|date',
            'test_time' => 'required',
            'error_code' => 'nullable|string',
            'tested_by' => 'required|string',
            'equipment_used' => 'required|string',
            'equipment_serial_number' => 'required|string',
            'catridge_serial_number' => 'required|string',
            'machine_sample_detection' => 'nullable|string',
            'device_status' => 'nullable|string',
            'hiv1_positive_control' => 'required|string',
            'hiv2_positive_control' => 'required|string',
            'negative_control' => 'required|string',
            'device_analysis' => 'nullable|string',
            'device_software_version' => 'nullable|string',
            'device_mode' => 'nullable|string',
            'test_summary' => 'nullable|string',
            ]);

            $pocEquipmentDetail = PocEquipmentDetail::create($validatedData);

            \Log::info('POC Equipment Detail stored successfully', ['id' => $pocEquipmentDetail->id]);

            return response()->json([
            'message' => 'POC Equipment Detail recorded successfully',
            'data' => $pocEquipmentDetail
            ], 201);
        } catch (\Exception $e) {

            \Log::error('Error storing POC Equipment Detail: ' . $e->getMessage());
            return response()->json([
            'message' => 'Failed to persist POC Equipment Detail',
            'error' => $e->getMessage()
            ], 500);
        }
    }
}
