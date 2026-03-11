<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Carbon;

class StatisticsService
{
    // I(imp) resolve period string to start-of-period Carbon instance
    private function resolveFrom(string $period): Carbon
    {
        return match ($period) {
            'daily'     => now()->startOfDay(),
            'weekly'    => now()->startOfWeek(),
            'monthly'   => now()->startOfMonth(),
            'quarterly' => now()->subMonths(3)->startOfDay(),
            default     => throw new \InvalidArgumentException("Invalid period: {$period}"),
        };
    }

    // I(imp) return blood sugar stats — single aggregate query instead of 4
    public function bloodSugarStats(User $user, string $period): array
    {
        $from = $this->resolveFrom($period);

        // P(erf) merged into one SQL: AVG + MIN + MAX + COUNT in single round-trip
        $agg = $user->bloodSugars()
            ->where('recorded_at', '>=', $from)
            ->selectRaw('AVG(value) as avg_val, MIN(value) as min_val, MAX(value) as max_val, COUNT(*) as cnt')
            ->first();

        return [
            'period'  => $period,
            'from'    => $from->toDateTimeString(),
            'to'      => now()->toDateTimeString(),
            'unit'    => 'mmol/L',
            'average' => round((float) $agg->avg_val, 2),
            'min'     => round((float) $agg->min_val, 2),
            'max'     => round((float) $agg->max_val, 2),
            'count'   => (int) $agg->cnt,
        ];
    }

    // I(imp) return blood pressure stats — single aggregate query instead of 4
    public function bloodPressureStats(User $user, string $period): array
    {
        $from = $this->resolveFrom($period);

        // P(erf) merged into one SQL: AVG systolic + diastolic + pulse + COUNT
        $agg = $user->bloodPressures()
            ->where('recorded_at', '>=', $from)
            ->selectRaw('AVG(systolic) as sys_avg, AVG(diastolic) as dia_avg, AVG(pulse) as pul_avg, COUNT(*) as cnt')
            ->first();

        return [
            'period'        => $period,
            'from'          => $from->toDateTimeString(),
            'to'            => now()->toDateTimeString(),
            'unit'          => 'mmHg',
            'systolic_avg'  => round((float) $agg->sys_avg, 1),
            'diastolic_avg' => round((float) $agg->dia_avg, 1),
            'pulse_avg'     => round((float) $agg->pul_avg, 1),
            'count'         => (int) $agg->cnt,
        ];
    }
}
