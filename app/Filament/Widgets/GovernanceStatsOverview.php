<?php

namespace App\Filament\Widgets;

use App\Services\PostureCalculator;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GovernanceStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $s = app(PostureCalculator::class)->dashboardSummary();

        return [
            Stat::make('Posture score', $s['posture_score'].'%')
                ->description('Continuous security posture')
                ->color('primary'),
            Stat::make('Open violations', (string) $s['open_violations'])
                ->description('Policy enforcement queue')
                ->color($s['open_violations'] > 0 ? 'warning' : 'success'),
            Stat::make('Pending reviews', (string) $s['pending_reviews'])
                ->description('Access review campaigns')
                ->color('info'),
            Stat::make('High risk items', (string) $s['high_risk_items'])
                ->description('Score ≥ 70')
                ->color($s['high_risk_items'] > 0 ? 'danger' : 'success'),
            Stat::make('Weekly hours saved', (string) $s['weekly_hours_saved'])
                ->description('$'.$s['weekly_value'].' ops value')
                ->color('success'),
        ];
    }
}
