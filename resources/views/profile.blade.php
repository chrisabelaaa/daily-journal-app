@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-user-circle"></i> User Profile
    </h1>
    <p class="page-subtitle">
        Manage your account information and update your personal details.
    </p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start;">
    <!-- Profile Information -->
    <div class="content-card">
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 25px; color: #2d3748;">
            <i class="fas fa-info-circle"></i> Profile Information
        </h2>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label" for="name">
                    <i class="fas fa-user"></i> Full Name
                </label>
                <input type="text" id="name" name="name" class="form-input" 
                       value="{{ old('name', auth()->user()->name) }}" 
                       required autofocus placeholder="Enter your full name">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="email">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input type="email" id="email" name="email" class="form-input" 
                       value="{{ old('email', auth()->user()->email) }}" 
                       required placeholder="Enter your email address">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">
                    <i class="fas fa-lock"></i> New Password
                    <span style="color: #6c757d; font-weight: 400; font-size: 0.9rem;">(leave blank to keep current password)</span>
                </label>
                <input type="password" id="password" name="password" class="form-input" 
                       placeholder="Enter new password">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password_confirmation">
                    <i class="fas fa-lock"></i> Confirm New Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                       placeholder="Confirm new password">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                <i class="fas fa-save"></i> Update Profile
            </button>
        </form>
    </div>
    
    <!-- Account Details -->
    <div class="content-card">
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 25px; color: #2d3748;">
            <i class="fas fa-id-card"></i> Account Details
        </h2>
        
        <div style="display: grid; gap: 20px;">
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #ff6b9d;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                    <i class="fas fa-user-tag"></i> Account Role
                </div>
                <div style="color: #6c757d; font-size: 1.1rem;">
                    {{ ucfirst(auth()->user()->role) }}
                </div>
            </div>
            
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #e91e63;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                    <i class="fas fa-calendar-plus"></i> Member Since
                </div>
                <div style="color: #6c757d; font-size: 1.1rem;">
                    {{ auth()->user()->created_at->format('F d, Y') }}
                </div>
            </div>
            
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid #c2185b;">
                <div style="font-weight: 600; color: #2d3748; margin-bottom: 5px;">
                    <i class="fas fa-clock"></i> Last Updated
                </div>
                <div style="color: #6c757d; font-size: 1.1rem;">
                    {{ auth()->user()->updated_at->format('F d, Y \a\t g:i A') }}
                </div>
            </div>
        </div>
        
        <!-- Profile Actions -->
        <div style="margin-top: 30px; display: grid; gap: 15px;">
            <a href="{{ route('profile.photo') }}" class="btn btn-secondary" style="justify-content: center;">
                <i class="fas fa-camera"></i> Update Profile Photo
            </a>
            
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="justify-content: center;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Account Statistics -->
<div class="content-card" style="margin-top: 30px;">
    <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 25px; color: #2d3748;">
        <i class="fas fa-chart-line"></i> Account Statistics
    </h2>
    
    <div class="cards-grid">
        <div style="background: #f8f9fa; border-radius: 12px; padding: 20px; text-align: center; border-top: 4px solid #ff6b9d;">
            <div style="font-size: 2.5rem; color: #ff6b9d; margin-bottom: 10px;">
                <i class="fas fa-journal-whills"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 700; color: #2d3748; margin-bottom: 5px;">
                {{ \App\Models\Journal::where('user_id', auth()->id())->count() }}
            </div>
            <div style="color: #6c757d; font-size: 0.9rem;">Total Journals</div>
        </div>
        
        <div style="background: #f8f9fa; border-radius: 12px; padding: 20px; text-align: center; border-top: 4px solid #e91e63;">
            <div style="font-size: 2.5rem; color: #e91e63; margin-bottom: 10px;">
                <i class="fas fa-tasks"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 700; color: #2d3748; margin-bottom: 5px;">
                {{ \App\Models\Activity::where('user_id', auth()->id())->count() }}
            </div>
            <div style="color: #6c757d; font-size: 0.9rem;">Total Activities</div>
        </div>
        
        <div style="background: #f8f9fa; border-radius: 12px; padding: 20px; text-align: center; border-top: 4px solid #c2185b;">
            <div style="font-size: 2.5rem; color: #c2185b; margin-bottom: 10px;">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div style="font-size: 2rem; font-weight: 700; color: #2d3748; margin-bottom: 5px;">
                {{ \App\Models\Journal::where('user_id', auth()->id())->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
            </div>
            <div style="color: #6c757d; font-size: 0.9rem;">This Week</div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
