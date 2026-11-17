@extends('layouts.marketing')
@section('title', 'Demo Access')
@section('content')
<section class="section">
    <h2>Demo credentials</h2>
    <p class="muted">All seeded users share password <code>{{ $password }}</code>. Prefer the Demo role for safe exploration.</p>
    <div class="panel" style="margin-top:1rem">
        <p><strong>Demo email:</strong> <code>{{ $email }}</code></p>
        <p><strong>Password:</strong> <code>{{ $password }}</code></p>
        <p class="muted">Also seeded: superadmin@, admin@, manager@, staff@, client@ under <code>ai-security-gov.test</code>.</p>
        <a class="btn" href="/admin/login">Open Filament admin</a>
    </div>
</section>
@endsection
