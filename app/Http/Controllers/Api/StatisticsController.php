<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct(private readonly StatisticsService $statistics) {}

    // I(imp) blood sugar stats; period: daily|weekly|monthly|quarterly
    public function bloodSugar(Request $request, string $period): JsonResponse
    {
        $this->validatePeriod($period);

        $stats = $this->statistics->bloodSugarStats($request->user(), $period);

        return response()->json($stats);
    }

    // I(imp) blood pressure stats; period: daily|weekly|monthly|quarterly
    public function bloodPressure(Request $request, string $period): JsonResponse
    {
        $this->validatePeriod($period);

        $stats = $this->statistics->bloodPressureStats($request->user(), $period);

        return response()->json($stats);
    }

    private function validatePeriod(string $period): void
    {
        if (!in_array($period, ['daily', 'weekly', 'monthly', 'quarterly'], true)) {
            abort(422, 'Invalid period. Allowed: daily, weekly, monthly, quarterly.');
        }
    }
}
