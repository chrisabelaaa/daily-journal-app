@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 25px;">
        <div style="position: relative;">
            @if(auth()->user()->photo)
                <img src="{{ asset('storage/profile/' . auth()->user()->photo) }}" 
                     alt="Profile Photo" 
                     style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; 
                            border: 4px solid transparent; 
                            background: linear-gradient(135deg, #ff6b9d, #e91e63) padding-box, 
                                       linear-gradient(135deg, #ff6b9d, #e91e63) border-box;
                            box-shadow: 0 10px 25px rgba(255, 107, 157, 0.3);">
            @else
                <div style="width: 80px; height: 80px; border-radius: 50%; 
                           background: linear-gradient(135deg, #ff6b9d, #e91e63);
                           display: flex; align-items: center; justify-content: center; color: white;
                           font-size: 2rem; font-weight: 700; 
                           box-shadow: 0 10px 25px rgba(255, 107, 157, 0.3);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            
            <!-- Camera icon overlay -->
            <a href="{{ route('profile.photo') }}" 
               style="position: absolute; bottom: 0; right: 0; 
                      width: 30px; height: 30px; border-radius: 50%; 
                      background: linear-gradient(135deg, #e91e63, #c2185b);
                      display: flex; align-items: center; justify-content: center; 
                      color: white; font-size: 0.9rem; text-decoration: none;
                      box-shadow: 0 3px 10px rgba(233, 30, 99, 0.4);
                      transition: all 0.3s ease;"
               onmouseover="this.style.transform='scale(1.1)'"
               onmouseout="this.style.transform='scale(1)'">
                <i class="fas fa-camera"></i>
            </a>
        </div>
        
        <div style="flex: 1;">
            <h1 class="page-title" style="margin-bottom: 5px;">
                <i class="fas fa-home"></i> Welcome back, {{ auth()->user()->name }}!
            </h1>
            <p class="page-subtitle" style="margin-bottom: 0;">
                Manage your journals, track your activities, and stay organized with your personal dashboard.
            </p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="content-card">
    <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 25px; color: #2d3748;">
        <i class="fas fa-bolt"></i> Quick Actions
    </h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('journals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Journal
            </a>
        @endif
        
        <a href="{{ route('journals.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> View All Journals
        </a>
        
        <a href="{{ route('activities.index') }}" class="btn btn-secondary">
            <i class="fas fa-tasks"></i> Manage Activities
        </a>
        
        <a href="{{ route('profile') }}" class="btn btn-secondary">
            <i class="fas fa-user-edit"></i> Edit Profile
        </a>
    </div>
</div>

<!-- Two Column Layout for Journals and Activities -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 25px; align-items: start;">
    
    <!-- Recent Journals Column -->
    <div class="content-card" style="height: 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="font-size: 1.8rem; font-weight: 600; color: #2d3748; margin: 0;">
                <i class="fas fa-journal-whills"></i> Recent Journals
            </h2>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('journals.create') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                <i class="fas fa-plus"></i> Add
            </a>
            @endif
        </div>
        
        @if(\App\Models\Journal::where('user_id', auth()->id())->exists())
            <div style="display: grid; gap: 15px;">
                @foreach(\App\Models\Journal::where('user_id', auth()->id())->latest()->take(3)->get() as $journal)
                <div style="padding: 18px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #ff6b9d; transition: all 0.3s ease;" 
                     onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 15px rgba(255,107,157,0.2)'"
                     onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: #2d3748;">
                        <a href="{{ route('journals.show', $journal) }}" style="text-decoration: none; color: inherit;">
                            {{ Str::limit($journal->title, 50) }}
                        </a>
                    </h3>
                    <p style="color: #6c757d; margin-bottom: 10px; line-height: 1.5; font-size: 0.9rem;">
                        {{ Str::limit($journal->content, 80) }}
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: #8e8e93;">
                        <span><i class="fas fa-calendar"></i> {{ $journal->created_at->format('M d, Y') }}</span>
                        <a href="{{ route('journals.show', $journal) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.85rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('journals.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i> View All Journals
                </a>
            </div>
        @else
            <div style="text-align: center; padding: 40px 20px;">
                <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;">
                    <i class="fas fa-journal-whills"></i>
                </div>
                <p style="color: #6c757d; font-size: 0.95rem; margin-bottom: 20px;">
                    No journals yet. Start documenting your thoughts!
                </p>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('journals.create') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 0.9rem;">
                    <i class="fas fa-plus"></i> Create First Journal
                </a>
                @endif
            </div>
        @endif
    </div>
    
    <!-- Recent Activities Column -->
    <div class="content-card" style="height: 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="font-size: 1.8rem; font-weight: 600; color: #2d3748; margin: 0;">
                <i class="fas fa-tasks"></i> Recent Activities
            </h2>
            <a href="{{ route('activities.create') }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                <i class="fas fa-plus"></i> Add
            </a>
        </div>
        
        @if(\App\Models\Activity::where('user_id', auth()->id())->exists())
            <div style="display: grid; gap: 15px;">
                @foreach(\App\Models\Activity::where('user_id', auth()->id())->latest()->take(3)->get() as $activity)
                <div style="padding: 18px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #e91e63; transition: all 0.3s ease;" 
                     onmouseover="this.style.transform='translateX(5px)'; this.style.boxShadow='0 5px 15px rgba(233,30,99,0.2)'"
                     onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='none'">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 8px; color: #2d3748;">
                        <a href="{{ route('activities.show', $activity) }}" style="text-decoration: none; color: inherit;">
                            {{ Str::limit($activity->title, 50) }}
                        </a>
                    </h3>
                    <p style="color: #6c757d; margin-bottom: 10px; line-height: 1.5; font-size: 0.9rem;">
                        {{ Str::limit($activity->description, 80) }}
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: #8e8e93;">
                        <span><i class="fas fa-calendar"></i> {{ $activity->created_at->format('M d, Y') }}</span>
                        <a href="{{ route('activities.show', $activity) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.85rem;">
                            <i class="fas fa-eye"></i> View
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i> View All Activities
                </a>
            </div>
        @else
            <div style="text-align: center; padding: 40px 20px;">
                <div style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;">
                    <i class="fas fa-tasks"></i>
                </div>
                <p style="color: #6c757d; font-size: 0.95rem; margin-bottom: 20px;">
                    No activities yet. Start organizing your tasks!
                </p>
                <a href="{{ route('activities.create') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 0.9rem;">
                    <i class="fas fa-plus"></i> Create First Activity
                </a>
            </div>
        @endif
    </div>
    
</div>

<!-- Welcome Message for New Users -->
@if(\App\Models\Journal::where('user_id', auth()->id())->count() == 0 && \App\Models\Activity::where('user_id', auth()->id())->count() == 0)
<div class="content-card" style="text-align: center;">
    <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.3;">
        <i class="fas fa-rocket"></i>
    </div>
    <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 15px; color: #2d3748;">
        Ready to get started?
    </h2>
    <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 30px; line-height: 1.6;">
        Welcome to JurnalKu! Start by creating your first journal entry or activity to begin your journey.
    </p>
    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('journals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Your First Journal
            </a>
        @endif
        <a href="{{ route('activities.create') }}" class="btn btn-secondary">
            <i class="fas fa-tasks"></i> Add Your First Activity
        </a>
    </div>
</div>
@endif

@endsection

@section('styles')
<style>
    @media (max-width: 1100px) {
        /* Make layout stack on smaller screens */
        div[style*="grid-template-columns: repeat(auto-fit, minmax(500px, 1fr))"] {
            grid-template-columns: 1fr !important;
        }
    }
    
    @media (max-width: 768px) {
        .page-header > div {
            flex-direction: column !important;
            text-align: center !important;
            gap: 15px !important;
        }
        
        .page-header img,
        .page-header > div > div:first-child > div {
            width: 60px !important;
            height: 60px !important;
            font-size: 1.5rem !important;
        }
        
        .page-header a {
            width: 25px !important;
            height: 25px !important;
            font-size: 0.8rem !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
// Add some interactive animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate stat cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection
