@extends('layouts.app')

@section('title', 'My Journals')

@section('content')
<!-- Success/Error Messages -->
@if(session('status'))
<div style="background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
    <i class="fas fa-check-circle"></i> {{ session('status') }}
</div>
@endif

@if($errors->any())
<div style="background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
    <i class="fas fa-exclamation-circle"></i> 
    <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-journal-whills"></i> My Journals
    </h1>
    <p class="page-subtitle">
        Manage and organize all your journal entries in one place.
    </p>
</div>

<!-- Search and Actions -->
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="flex: 1; min-width: 250px;">
            <form method="GET" action="{{ route('journals.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="Search journals..." 
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
                    <a href="{{ route('journals.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>
        
        <a href="{{ route('journals.archived') }}" class="btn btn-secondary">
            <i class="fas fa-archive"></i> Archived Journals
        </a>
    </div>
</div>

<!-- Journals Grid -->
@if($journals->count() > 0)
    <div class="cards-grid">
        @foreach($journals as $journal)
        <div class="content-card" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #2d3748; margin: 0 0 8px 0;">
                        {{ $journal->title }}
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px;">
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
                    <i class="fas fa-calendar"></i> {{ $journal->created_at->format('M d, Y') }}
                    <span style="margin-left: 15px;">
                        <i class="fas fa-clock"></i> {{ $journal->created_at->format('g:i A') }}
                    </span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('journals.edit', $journal->id) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('journals.archive', $journal->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Archive this journal?')" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.9rem;">
                            <i class="fas fa-archive"></i> Archive
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
            <i class="fas fa-chart-bar"></i> Journal Statistics
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #ff6b9d;">
                <div style="font-size: 2rem; font-weight: 700; color: #ff6b9d;">{{ $journals->count() }}</div>
                <div style="color: #6c757d; font-size: 0.9rem;">Total Journals</div>
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
            <i class="fas fa-journal-whills"></i>
        </div>
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 15px; color: #2d3748;">
            No Journals Found
        </h2>
        <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 30px; line-height: 1.6;">
            @if(request('search'))
                No journals match your search criteria. Try different keywords or browse all journals.
            @else
                Belum ada activity yang berstatus Done atau Unfinished (deadline terlewat).
            @endif
        </p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            @if(request('search'))
                <a href="{{ route('journals.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> View All Journals
                </a>
            @endif
        </div>
    </div>
@endif

@endsection
