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
      try {
            // Filters
            $facilityId   = $request->query('facility_id');
            $serialNumber = $request->query('serial_number');
            $startDate    = $request->query('start_date');
            $endDate      = $request->query('end_date');

            // Base query
            $query = PocEquipmentDetail::query();

            if ($facilityId) $query->where('facility_id', $facilityId);
            if ($serialNumber) $query->where('equipment_serial_number', $serialNumber);
            if ($startDate && $endDate) $query->whereBetween('test_date', [$startDate, $endDate]);

            // Time boundaries
            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            // Clone for metrics
            $baseQuery = clone $query;

            // ---- OVERALL METRICS ----
            $totalDevices = $baseQuery->distinct('equipment_serial_number')->count('equipment_serial_number');
            $totalTestsConducted = $baseQuery->distinct('sample_id')->count('sample_id');
            $reportedToday = (clone $query)->whereDate('test_date', $today)->count();
            $reportedYesterday = (clone $query)->whereDate('test_date', $yesterday)->count();
            $reportedThisWeek = (clone $query)->whereBetween('test_date', [$startOfWeek, $endOfWeek])->count();

            // Last reported overall
            $lastReportedRow = (clone $query)->orderByDesc('test_date')->orderByDesc('test_time')->first();
            $lastReported = $lastReportedRow ? $lastReportedRow->test_date . ' ' . ($lastReportedRow->test_time ?? '') : null;

            // ---- PER FACILITY BREAKDOWN ----
            $facilityBreakdown = PocEquipmentDetail::select(
                    'facility_id',
                    DB::raw('COUNT(DISTINCT equipment_serial_number) as total_devices'),
                    DB::raw('SUM(CASE WHEN DATE(test_date) = CURDATE() THEN 1 ELSE 0 END) as reported_today'),
                    DB::raw('SUM(CASE WHEN DATE(test_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN 1 ELSE 0 END) as reported_yesterday'),
                    DB::raw('SUM(CASE WHEN YEARWEEK(test_date, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) as reported_this_week'),
                    DB::raw('MAX(CONCAT(test_date, " ", IFNULL(test_time, ""))) as last_reported')
                )
                ->when($facilityId, fn($q) => $q->where('facility_id', $facilityId))
                ->when($serialNumber, fn($q) => $q->where('equipment_serial_number', $serialNumber))
                ->when($startDate && $endDate, fn($q) => $q->whereBetween('test_date', [$startDate, $endDate]))
                ->groupBy('facility_id')
                ->get();

            return response()->json([
                'status' => 'success',
                'filters' => [
                    'facility_id' => $facilityId,
                    'serial_number' => $serialNumber,
                    'date_range' => $startDate && $endDate ? [$startDate, $endDate] : null
                ],
                'summary' => [
                    'total_devices' => $totalDevices,
                    'total_tests_conducted' => $totalTestsConducted,
                    'devices_reported_today' => $reportedToday,
                    'devices_reported_yesterday' => $reportedYesterday,
                    'devices_reported_this_week' => $reportedThisWeek,
                    'last_reported' => $lastReported,
                ],
                'facility_breakdown' => $facilityBreakdown
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching POC Equipment statistics: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
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
