@extends('layouts.marketing')
@section('title', 'Features')
@section('content')
<section class="section">
    <h2>Feature catalog</h2>
    <p class="muted">Every capability maps to a toggleable module so teams only run what their AI program needs.</p>
    @foreach($modules as $category => $items)
        <h3 style="margin-top:1.75rem;text-transform:capitalize">{{ str_replace('_',' ', $category) }}</h3>
        <div class="grid">
            @foreach($items as $module)
                <div class="panel">
                    <div class="badge">{{ ($module['enabled'] ?? false) ? 'ON' : 'OFF' }}</div>
                    <h3 style="margin:0.5rem 0;font-size:1.05rem">{{ $module['name'] }}</h3>
                    <p class="muted" style="margin:0">{{ $module['description'] }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</section>
@endsection
