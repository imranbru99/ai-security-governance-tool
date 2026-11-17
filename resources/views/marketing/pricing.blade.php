@extends('layouts.marketing')
@section('title', 'Pricing & ROI')
@section('content')
<section class="section">
    <h2>ROI model</h2>
    <p class="muted">Enabled modules reclaim about <strong>{{ $weeklyHours }}</strong> hours/week. At ${{ number_format($summary['hourly_rate'] ?? config('aisg.hourly_rate'), 0) }}/hr that is <strong>${{ number_format($summary['weekly_value'], 0) }}</strong> weekly ops value versus ~${{ number_format($summary['monthly_cost'], 0) }}/mo platform cost.</p>
    <div class="grid" style="margin-top:1.25rem">
        <div class="panel">
            <h3>Starter</h3>
            <div class="kpi">$1,200<span style="font-size:1rem;color:var(--muted)">/mo</span></div>
            <p class="muted">Policies, access reviews, audit logs — up to 3 AI assets.</p>
        </div>
        <div class="panel">
            <h3>Growth</h3>
            <div class="kpi">$2,400<span style="font-size:1rem;color:var(--muted)">/mo</span></div>
            <p class="muted">Full posture + risk scoring + enforcement for mid-size AI portfolios.</p>
        </div>
        <div class="panel">
            <h3>Enterprise</h3>
            <div class="kpi">Custom</div>
            <p class="muted">SSO, PDF packs, catalog scrape, attendance bridge, dedicated advisory.</p>
        </div>
    </div>
    <p class="muted" style="margin-top:1rem">{{ $moduleCount }} modules ship in-box; toggle what you need.</p>
</section>
@endsection
