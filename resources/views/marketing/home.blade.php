@extends('layouts.marketing')

@section('title', 'AegisGov — AI Security & Governance')
@section('meta_description', 'AI security and governance tool for policy enforcement, access reviews, risk scoring, audit logs, and continuous security posture management.')

@section('content')
<section class="hero">
    <span class="badge">AI Security &amp; Governance</span>
    <h1>AegisGov</h1>
    <p>Policy enforcement, access reviews, risk scoring, audit logs, and continuous security posture — modular for security, GRC, and AI platform teams.</p>
    <div class="cta-row">
        <a class="btn" href="{{ route('demo') }}">Open demo</a>
        <a class="btn btn-outline" href="{{ route('modules') }}">Toggle modules</a>
    </div>
</section>

<section class="section">
    <div class="grid">
        <div class="panel"><div class="muted">Posture score</div><div class="kpi">{{ $summary['posture_score'] }}%</div></div>
        <div class="panel"><div class="muted">Active policies</div><div class="kpi">{{ $summary['active_policies'] }}</div></div>
        <div class="panel"><div class="muted">Modules on</div><div class="kpi">{{ $enabledCount }}</div></div>
        <div class="panel"><div class="muted">Hours saved / week</div><div class="kpi">{{ $weeklyHours }}</div></div>
    </div>
</section>

<section class="section">
    <h2>Live governance snapshot</h2>
    <p class="muted">Seeded demo data shows policies, access reviews, and posture checks in one slate-accented control plane.</p>
    <div class="grid" style="margin-top:1rem">
        @foreach($policies as $policy)
            <div class="panel">
                <div class="badge">{{ $policy->category }}</div>
                <h3 style="margin:0.55rem 0 0.35rem;font-size:1.05rem">{{ $policy->title }}</h3>
                <p class="muted" style="margin:0">{{ $policy->summary }}</p>
            </div>
        @endforeach
    </div>
</section>

<section class="section">
    <h2>Dashboard</h2>
    <img src="{{ asset('docs/screenshots/dashboard.png') }}" alt="AegisGov AI security governance dashboard" style="width:100%;border-radius:0.9rem;border:1px solid rgba(51,65,85,.18);box-shadow:0 18px 40px rgba(15,23,42,.08)">
</section>
@endsection
