<?php

namespace App\Http\Controllers;

use App\Models\AccessReview;
use App\Models\AiAsset;
use App\Models\AuditLog;
use App\Models\GovernancePolicy;
use App\Models\PostureCheck;
use App\Models\RiskAssessment;
use App\Services\ModuleManager;
use App\Services\PostureCalculator;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function home(ModuleManager $modules, PostureCalculator $posture): View
    {
        return view('marketing.home', [
            'accent' => config('aisg.accent'),
            'modules' => $modules->all(),
            'enabledCount' => $modules->all()->where('enabled', true)->count(),
            'weeklyHours' => $modules->weeklyHoursSaved(),
            'summary' => $posture->dashboardSummary(),
            'policies' => GovernancePolicy::query()->where('status', 'active')->take(5)->get(),
            'reviews' => AccessReview::query()->latest()->take(3)->get(),
            'checks' => PostureCheck::query()->orderByDesc('score')->take(4)->get(),
        ]);
    }

    public function features(ModuleManager $modules): View
    {
        return view('marketing.features', [
            'accent' => config('aisg.accent'),
            'modules' => $modules->all()->groupBy('category'),
        ]);
    }

    public function modules(ModuleManager $modules): View
    {
        return view('marketing.modules', [
            'accent' => config('aisg.accent'),
            'modules' => $modules->all(),
        ]);
    }

    public function policies(): View
    {
        return view('marketing.policies', [
            'accent' => config('aisg.accent'),
            'policies' => GovernancePolicy::query()->with('owner')->orderBy('code')->get(),
        ]);
    }

    public function reviews(): View
    {
        return view('marketing.reviews', [
            'accent' => config('aisg.accent'),
            'reviews' => AccessReview::query()->with('reviewer')->latest()->get(),
            'risks' => RiskAssessment::query()->with('asset')->orderByDesc('score')->get(),
        ]);
    }

    public function posture(PostureCalculator $posture): View
    {
        return view('marketing.posture', [
            'accent' => config('aisg.accent'),
            'summary' => $posture->dashboardSummary(),
            'checks' => PostureCheck::query()->with('owner')->orderBy('domain')->get(),
            'assets' => AiAsset::query()->where('is_active', true)->get(),
            'audits' => AuditLog::query()->with('actor')->latest('occurred_at')->take(8)->get(),
        ]);
    }

    public function pricing(ModuleManager $modules, PostureCalculator $posture): View
    {
        return view('marketing.pricing', [
            'accent' => config('aisg.accent'),
            'weeklyHours' => $modules->weeklyHoursSaved(),
            'summary' => $posture->dashboardSummary(),
            'moduleCount' => $modules->all()->count(),
        ]);
    }

    public function demo(): View
    {
        return view('marketing.demo', [
            'accent' => config('aisg.accent'),
            'email' => config('aisg.demo.email'),
            'password' => config('aisg.demo.password'),
        ]);
    }
}
