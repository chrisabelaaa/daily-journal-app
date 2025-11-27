@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="margin: 0 auto; max-width: 480px; padding: 2.5rem 2rem; background: #F2C4CD; border-radius: 1.25rem; box-shadow: 0 8px 32px rgba(5, 31, 69, 0.10); box-sizing: border-box;">
    <div class="dashboard-title" style="font-size: 2rem; font-weight: 700; color: #051F45; text-align: center; margin-bottom: 2rem;">Activity Detail</div>
    <div style="margin-bottom: 1.5rem;">
        <label style="color:#051F45; font-weight:600; font-size:1.05rem;">Title</label>
        <div style="padding:0.75rem 1rem; background:#fff; border:1.5px solid #051F45; border-radius:0.5rem; color:#051F45; font-size:1.1rem; margin-bottom:1rem;">{{ $activity->title }}</div>
        <label style="color:#051F45; font-weight:600; font-size:1.05rem;">Description</label>
        <div style="padding:0.75rem 1rem; background:#fff; border:1.5px solid #051F45; border-radius:0.5rem; color:#051F45; font-size:1.05rem; min-height:80px;">{!! nl2br(e($activity->description)) !!}</div>
        <div style="margin-top:1.5rem; color:#6b7280; font-size:0.98rem;">Due date: {{ $activity->due_date }}</div>
        <div style="margin-top:0.5rem; color:#6b7280; font-size:0.98rem;">Status: {{ $activity->status }}</div>
    </div>
    <div style="text-align:right;">
        <a href="{{ route('activities.index') }}" style="background:#051F45; color:#F2C4CD; padding:0.7rem 1.5rem; border-radius:0.5rem; font-weight:600; font-size:1rem; text-decoration:none;">Back</a>
    </div>
</div>
@endsection