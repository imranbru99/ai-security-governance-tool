@extends('layouts.marketing')
@section('title', 'Modules')
@section('content')
<section class="section">
    <h2>Module matrix</h2>
    <p class="muted">Core modules stay on. Optional modules (catalog scrape, attendance bridge, PDF packs, AI assist) can be disabled per tenant.</p>
    <div class="panel" style="overflow-x:auto;margin-top:1rem">
        <table>
            <thead>
                <tr><th>Module</th><th>Key</th><th>Category</th><th>Core</th><th>Status</th><th>Hrs/wk</th></tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                    <tr>
                        <td>{{ $module['name'] }}</td>
                        <td><code>{{ $module['key'] }}</code></td>
                        <td>{{ $module['category'] ?? '—' }}</td>
                        <td>{{ ($module['core'] ?? false) ? 'Yes' : 'No' }}</td>
                        <td>{{ ($module['enabled'] ?? false) ? 'Enabled' : 'Disabled' }}</td>
                        <td>{{ $module['hours_saved_weekly'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
