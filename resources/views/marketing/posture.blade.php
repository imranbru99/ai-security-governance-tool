@extends('layouts.marketing')
@section('title', 'Security Posture')
@section('content')
<section class="section">
    <h2>Continuous posture</h2>
    <p class="muted">Composite score {{ $summary['posture_score'] }}% · {{ $summary['open_violations'] }} open violations · {{ $summary['audit_events'] }} audit events</p>
    <div class="grid" style="margin-top:1rem">
        @foreach($checks as $check)
            <div class="panel">
                <div class="badge">{{ $check->status }} · {{ $check->domain }}</div>
                <h3 style="margin:0.5rem 0;font-size:1.05rem">{{ $check->name }}</h3>
                <div class="kpi" style="font-size:1.4rem">{{ $check->score }}</div>
                <p class="muted" style="margin:0.4rem 0 0">{{ $check->finding }}</p>
            </div>
        @endforeach
    </div>
</section>
<section class="section">
    <h2>AI inventory</h2>
    <div class="grid">
        @foreach($assets as $asset)
            <div class="panel">
                <div class="badge">{{ $asset->asset_type }}</div>
                <h3 style="margin:0.5rem 0;font-size:1.05rem">{{ $asset->name }}</h3>
                <p class="muted" style="margin:0">{{ $asset->data_classification }} · tier {{ $asset->risk_tier }} · {{ $asset->environment }}</p>
            </div>
        @endforeach
    </div>
</section>
<section class="section">
    <h2>Recent audit logs</h2>
    <div class="panel" style="overflow-x:auto">
        <table>
            <thead><tr><th>Event</th><th>Action</th><th>Severity</th><th>Actor</th><th>When</th></tr></thead>
            <tbody>
                @foreach($audits as $log)
                    <tr>
                        <td>{{ $log->event_id }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->severity }}</td>
                        <td>{{ $log->actor?->name ?? 'system' }}</td>
                        <td>{{ optional($log->occurred_at)->toDateTimeString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
