<?php

namespace App\Services;

use App\Models\AccessReview;
use App\Models\AuditLog;
use App\Models\GovernancePolicy;
use App\Models\PolicyViolation;
use App\Models\PostureCheck;
use App\Models\RiskAssessment;

class PostureCalculator
{
    public function dashboardSummary(): array
    {
        $postureAvg = (float) (PostureCheck::query()->avg('score') ?? 0);
        $openViolations = PolicyViolation::query()->whereIn('status', ['open', 'investigating'])->count();
        $pendingReviews = AccessReview::query()->whereIn('status', ['draft', 'in_progress'])->count();
        $highRisk = RiskAssessment::query()->where('score', '>=', 70)->count();
        $auditEvents = AuditLog::query()->count();
        $policies = GovernancePolicy::query()->where('status', 'active')->count();
        $weeklyHours = app(ModuleManager::class)->weeklyHoursSaved();
        $hourly = (float) config('aisg.hourly_rate', 85);

        return [
            'posture_score' => round($postureAvg, 1),
            'open_violations' => $openViolations,
            'pending_reviews' => $pendingReviews,
            'high_risk_items' => $highRisk,
            'audit_events' => $auditEvents,
            'active_policies' => $policies,
            'weekly_hours_saved' => $weeklyHours,
            'weekly_value' => round($weeklyHours * $hourly, 2),
            'monthly_cost' => (float) config('aisg.monthly_cost', 2400),
        ];
    }
}
