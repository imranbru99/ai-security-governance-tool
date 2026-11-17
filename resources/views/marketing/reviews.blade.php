@extends('layouts.marketing')
@section('title', 'Access Reviews & Risk')
@section('content')
<section class="section">
    <h2>Access reviews</h2>
    <div class="grid">
        @foreach($reviews as $review)
            <div class="panel">
                <div class="badge">{{ $review->status }}</div>
                <h3 style="margin:0.5rem 0;font-size:1.05rem">{{ $review->title }}</h3>
                <p class="muted" style="margin:0">{{ $review->entitlements_reviewed }}/{{ $review->entitlements_total }} reviewed · {{ $review->flags_count }} flags · due {{ optional($review->due_on)->toDateString() }}</p>
            </div>
        @endforeach
    </div>
</section>
<section class="section">
    <h2>Risk scores</h2>
    <div class="panel" style="overflow-x:auto">
        <table>
            <thead><tr><th>Code</th><th>Subject</th><th>Score</th><th>Level</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($risks as $risk)
                    <tr>
                        <td>{{ $risk->code }}</td>
                        <td>{{ $risk->subject_name }}</td>
                        <td>{{ $risk->score }}</td>
                        <td>{{ $risk->level }}</td>
                        <td>{{ $risk->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
