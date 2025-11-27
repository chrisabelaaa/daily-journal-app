@extends('layouts.app')

@section('title', 'Archived Journals')

@section('content')
<!-- Success/Error Messages -->
@if(session('status'))
<div style="background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
    <i class="fas fa-check-circle"></i> {{ session('status') }}
</div>
@endif

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-archive"></i> Archived Journals
    </h1>
    <p class="page-subtitle">
        View and manage your archived journal entries.
    </p>
</div>

<!-- Search and Actions -->
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="flex: 1; min-width: 250px;">
            <form method="GET" action="{{ route('journals.archived') }}" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="Search archived journals..." 
                       value="{{ request('search') }}" class="form-input" 
                       style="margin-bottom: 0; flex: 1; min-width: 200px;">
                
                <select name="status" class="form-input" style="margin-bottom: 0; min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="Done" {{ request('status') == 'Done' ? 'selected' : '' }}>Done</option>
                    <option value="Unfinished" {{ request('status') == 'Unfinished' ? 'selected' : '' }}>Unfinished</option>
                </select>
                
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Search
                </button>
                
                @if(request('search') || request('status'))
                    <a href="{{ route('journals.archived') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>
        
        <a href="{{ route('journals.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Journals
        </a>
    </div>
</div>

<!-- Archived Journals Grid -->
@if($journals->count() > 0)
    <div class="cards-grid">
        @foreach($journals as $journal)
        <div class="content-card" style="margin-bottom: 0; background: #f8f9fa;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <h3 style="font-size: 1.3rem; font-weight: 600; color: #2d3748; margin: 0;">
                            {{ $journal->title }}
                        </h3>
                        <span style="
                            padding: 2px 8px;
                            font-size: 0.7rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            border-radius: 12px;
                            background-color: #6c757d;
                            color: white;
                        ">
                            <i class="fas fa-archive"></i> ARCHIVED
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <span class="status-badge" style="
                            display: inline-block;
                            padding: 4px 12px;
                            font-size: 0.75rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            border-radius: 20px;
                            background-color: {{ $journal->status === 'Done' ? '#10b981' : '#ef4444' }};
                            color: white;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        ">
                            {{ $journal->status }}
                        </span>
                        
                        @if($journal->deadline)
                        <span style="font-size: 0.85rem; color: #6c757d;">
                            <i class="fas fa-clock"></i> Deadline: {{ \Carbon\Carbon::parse($journal->deadline)->format('M d, Y H:i') }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <p style="color: #6c757d; line-height: 1.6; margin-bottom: 15px;">
                {{ Str::limit($journal->description, 150) }}
            </p>
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid #e9ecef;">
                <div style="color: #8e8e93; font-size: 0.9rem;">
                    <i class="fas fa-calendar"></i> Created: {{ $journal->created_at->format('M d, Y') }}
                    <span style="margin-left: 15px;">
                        <i class="fas fa-archive"></i> Archived: {{ $journal->archived_at->format('M d, Y') }}
                    </span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <form action="{{ route('journals.restore', $journal->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Restore this journal?')" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                            <i class="fas fa-undo"></i> Restore
                        </button>
                    </form>
                    <form action="{{ route('journals.force-delete', $journal->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Permanently delete this journal? This action cannot be undone!')" class="btn btn-danger" style="padding: 8px 16px; font-size: 0.9rem;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Statistics -->
    <div class="content-card" style="text-align: center;">
        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 20px; color: #2d3748;">
            <i class="fas fa-chart-bar"></i> Archived Statistics
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #6c757d;">
                <div style="font-size: 2rem; font-weight: 700; color: #6c757d;">{{ $journals->count() }}</div>
                <div style="color: #6c757d; font-size: 0.9rem;">Total Archived</div>
            </div>
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #10b981;">
                <div style="font-size: 2rem; font-weight: 700; color: #10b981;">
                    {{ $journals->where('status', 'Done')->count() }}
                </div>
                <div style="color: #6c757d; font-size: 0.9rem;">Done</div>
            </div>
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #ef4444;">
                <div style="font-size: 2rem; font-weight: 700; color: #ef4444;">
                    {{ $journals->where('status', 'Unfinished')->count() }}
                </div>
                <div style="color: #6c757d; font-size: 0.9rem;">Unfinished</div>
            </div>
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="content-card" style="text-align: center; padding: 60px 30px;">
        <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.3;">
            <i class="fas fa-archive"></i>
        </div>
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 15px; color: #2d3748;">
            No Archived Journals
        </h2>
        <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 30px; line-height: 1.6;">
            @if(request('search'))
                No archived journals match your search criteria.
            @else
                You don't have any archived journals yet.
            @endif
        </p>
        <a href="{{ route('journals.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Journals
        </a>
    </div>
@endif

@endsection
