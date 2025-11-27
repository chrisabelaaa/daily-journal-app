@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="margin: 0 auto; max-width: 480px; padding: 2.5rem 2rem; background: #F2C4CD; border-radius: 1.25rem; box-shadow: 0 8px 32px rgba(5, 31, 69, 0.10); box-sizing: border-box;">
    <div class="dashboard-title" style="font-size: 2rem; font-weight: 700; color: #051F45; text-align: center; margin-bottom: 2rem;">Journal Detail</div>
    <div style="margin-bottom: 1.5rem;">
        <label style="color:#051F45; font-weight:600; font-size:1.05rem;">Title</label>
        <div style="padding:0.75rem 1rem; background:#fff; border:1.5px solid #051F45; border-radius:0.5rem; color:#051F45; font-size:1.1rem; margin-bottom:1rem;">{{ $journal->title }}</div>
        
        <label style="color:#051F45; font-weight:600; font-size:1.05rem;">Status</label>
        <div style="margin-bottom:1rem;">
            <span class="status-badge" style="
                display: inline-block;
                padding: 8px 16px;
                font-size: 0.85rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-radius: 20px;
                background-color: {{ $journal->status_badge_color }};
                color: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            ">
                {{ $journal->status_label }}
            </span>
        </div>
        
        <label style="color:#051F45; font-weight:600; font-size:1.05rem;">Content</label>
        <div style="padding:0.75rem 1rem; background:#fff; border:1.5px solid #051F45; border-radius:0.5rem; color:#051F45; font-size:1.05rem; min-height:120px;">{!! nl2br(e($journal->content)) !!}</div>
        <div style="margin-top:1.5rem; color:#6b7280; font-size:0.98rem;">Created at: {{ $journal->created_at->format('d M Y H:i') }}</div>
    </div>
    <div style="text-align:right;">
        <a href="{{ route('journals.index') }}" style="background:#051F45; color:#F2C4CD; padding:0.7rem 1.5rem; border-radius:0.5rem; font-weight:600; font-size:1rem; text-decoration:none;">Back</a>
    </div>
</div>
@endsection
