<?php

namespace App\Http\Controllers\API;

use App\Models\PocEquipmentDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class POCEquipmentDetailController extends Controller
{
    public function getStats(Request $request)
    {
        // Optional filters
        $facilityId   = $request->input('facility_id');
        $serialNumber = $request->input('equipment_serial_number');
        $dateRange    = $request->input('date_range'); // e.g. ['2025-10-01','2025-10-09']

        // Base query
        $query = PocEquipmentDetail::query();

        // Apply filters dynamically
        if ($facilityId) {
            $query->where('facility_id', $facilityId);
        }

        if ($serialNumber) {
            $query->where('equipment_serial_number', $serialNumber);
        }

        if ($dateRange && is_array($dateRange) && count($dateRange) === 2) {
            $query->whereBetween('test_date', [$dateRange[0], $dateRange[1]]);
        }

        // Date calculations
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd   = Carbon::now()->endOfWeek();

        // Clone query to reuse base filters
        $totalQuery     = clone $query;
        $todayQuery     = clone $query;
        $yesterdayQuery = clone $query;
        $weekQuery      = clone $query;

        // Stats computation
        $stats = [
            'total_devices' => $totalQuery->distinct('equipment_serial_number')->count('equipment_serial_number'),
            'reported_today' => $todayQuery->whereDate('test_date', $today)
                ->distinct('equipment_serial_number')->count('equipment_serial_number'),
            'reported_yesterday' => $yesterdayQuery->whereDate('test_date', $yesterday)
                ->distinct('equipment_serial_number')->count('equipment_serial_number'),
            'reported_this_week' => $weekQuery->whereBetween('test_date', [$weekStart, $weekEnd])
                ->distinct('equipment_serial_number')->count('equipment_serial_number'),
        ];

        return response()->json([
            'filters' => [
                'facility_id' => $facilityId,
                'equipment_serial_number' => $serialNumber,
                'date_range' => $dateRange,
            ],
            'data' => $stats,
        ]);
    }

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
            'sample_id' => 'nullable|string',
            'facility_id' => 'required|integer'
            ]);

            $pocEquipmentDetail = PocEquipmentDetail::updateOrCreate(
            [
            'test_date' => $validatedData['test_date'],
            'test_time' => $validatedData['test_time'],
            'equipment_serial_number' => $validatedData['equipment_serial_number'],
            'catridge_serial_number' => $validatedData['catridge_serial_number'],
            'sample_id' => $validatedData['sample_id'],
            'facility_id' => $validatedData['facility_id']
            ],
            $validatedData
            );

            \Log::info('POC Equipment Detail stored/updated successfully', ['id' => $pocEquipmentDetail->id]);

            return response()->json([
            'message' => 'POC Equipment Detail recorded/updated successfully',
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

    public function getEquipmentSummary($facilityId, $date)
    {
        try {
            $summary = PocEquipmentDetail::where('facility_id', $facilityId)
                ->whereDate('test_date', $date)
                ->get();

            return response()->json([
                'message' => 'POC Equipment Summary retrieved successfully',
                'data' => $summary
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error retrieving POC Equipment Summary: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to retrieve POC Equipment Summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
