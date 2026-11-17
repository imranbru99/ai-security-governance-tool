@extends('layouts.marketing')
@section('title', 'Policies')
@section('content')
<section class="section">
    <h2>Policy library</h2>
    <p class="muted">Versioned AI and security policies with enforcement flags and owners.</p>
    <div class="panel" style="overflow-x:auto;margin-top:1rem">
        <table>
            <thead><tr><th>Code</th><th>Title</th><th>Severity</th><th>Status</th><th>Owner</th><th>Enforced</th></tr></thead>
            <tbody>
                @foreach($policies as $policy)
                    <tr>
                        <td>{{ $policy->code }}</td>
                        <td>{{ $policy->title }}</td>
                        <td>{{ $policy->severity }}</td>
                        <td>{{ $policy->status }}</td>
                        <td>{{ $policy->owner?->name ?? '—' }}</td>
                        <td>{{ $policy->enforcement_enabled ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
