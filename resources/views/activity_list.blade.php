@extends('layouts.app')

@section('title', 'Activities')

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
        <i class="fas fa-tasks"></i> Activity List
    </h1>
    <p class="page-subtitle">
        Manage and organize all your activities and tasks.
    </p>
</div>

<!-- Search and Actions -->
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="flex: 1; min-width: 250px;">
            <form method="GET" action="{{ route('activities.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <input type="text" name="search" placeholder="Search activities..." 
                       value="{{ request('search') }}" class="form-input" 
                       style="margin-bottom: 0; flex: 1; min-width: 200px;">
                
                <select name="status" class="form-input" style="margin-bottom: 0; min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                </select>
                
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-search"></i> Search
                </button>
                
                @if(request('search') || request('status'))
                    <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
        </div>
        
        <a href="{{ route('activities.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Activity
        </a>
    </div>
</div>

<!-- Activities List -->
@if($activities->count() > 0)
    <div class="cards-grid">
        @foreach($activities as $activity)
        <div class="content-card" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                <div style="margin-right: 15px; margin-top: 5px;">
                    <input type="checkbox" class="activity-checkbox" value="{{ $activity->id }}" 
                           style="width: 18px; height: 18px; accent-color: #ff6b9d; cursor: pointer;">
                </div>
                
                <div style="flex: 1;">
                    <h3 style="font-size: 1.3rem; font-weight: 600; color: #2d3748; margin: 0 0 8px 0;">
                        {{ $activity->title }}
                    </h3>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <span class="status-badge" style="
                            display: inline-block;
                            padding: 4px 12px;
                            font-size: 0.75rem;
                            font-weight: 600;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            border-radius: 20px;
                            background-color: {{ $activity->status === 'Pending' ? '#fbbf24' : ($activity->status === 'In Progress' ? '#3b82f6' : ($activity->status === 'Done' ? '#10b981' : '#ef4444')) }};
                            color: white;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                        ">
                            {{ $activity->status }}
                        </span>
                        
                        <select onchange="updateActivityStatus({{ $activity->id }}, this.value)" 
                                style="
                                    padding: 4px 8px;
                                    font-size: 0.75rem;
                                    border: 1px solid #ddd;
                                    border-radius: 12px;
                                    background: white;
                                    color: #666;
                                    cursor: pointer;
                                    outline: none;
                                ">
                            <option value="">Change Status</option>
                            <option value="Pending" {{ $activity->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Progress" {{ $activity->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Done" {{ $activity->status === 'Done' ? 'selected' : '' }}>Done</option>
                            <option value="Unfinished" {{ $activity->status === 'Unfinished' ? 'selected' : '' }}>Unfinished</option>
                        </select>
                        
                        @if($activity->deadline)
                        <span style="
                            font-size: 0.8rem; 
                            color: {{ \Carbon\Carbon::parse($activity->deadline)->isPast() && $activity->status !== 'Done' ? '#ef4444' : '#6c757d' }};
                            font-weight: {{ \Carbon\Carbon::parse($activity->deadline)->isPast() && $activity->status !== 'Done' ? '600' : '400' }};
                        ">
                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($activity->deadline)->format('M d, Y H:i') }}
                            @if(\Carbon\Carbon::parse($activity->deadline)->isPast() && $activity->status !== 'Done')
                                <span style="color: #ef4444; font-weight: 600;">(OVERDUE)</span>
                            @endif
                        </span>
                        @endif
                    </div>
                </div>
                <div style="display: flex; gap: 5px; margin-left: 15px;">
                    <button onclick="showEditModal({{ $activity->id }}, '{{ addslashes($activity->title) }}', '{{ addslashes($activity->description) }}', '{{ $activity->status }}', '{{ $activity->due_date }}', '{{ $activity->deadline }}')" 
                            class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.85rem;">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this activity?')" 
                                class="btn btn-danger" style="padding: 5px 10px; font-size: 0.85rem;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <p style="color: #6c757d; line-height: 1.6; margin-bottom: 15px;">
                {{ Str::limit($activity->description, 150) }}
            </p>
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid #e9ecef;">
                <div style="color: #8e8e93; font-size: 0.9rem;">
                    <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($activity->due_date)->format('M d, Y') }}
                    <span style="margin-left: 15px;">
                        <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($activity->due_date)->format('g:i A') }}
                    </span>
                </div>
                <a href="{{ route('activities.show', $activity) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;">
                    <i class="fas fa-eye"></i> Read More
                </a>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Statistics -->
    <div class="content-card" style="text-align: center;">
        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 20px; color: #2d3748;">
            <i class="fas fa-chart-bar"></i> Activity Statistics
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px;">
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #ff6b9d;">
                <div style="font-size: 2rem; font-weight: 700; color: #ff6b9d;">{{ $activities->count() }}</div>
                <div style="color: #6c757d; font-size: 0.9rem;">Total Activities</div>
            </div>
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #fbbf24;">
                <div style="font-size: 2rem; font-weight: 700; color: #fbbf24;">
                    {{ $activities->where('status', 'Pending')->count() }}
                </div>
                <div style="color: #6c757d; font-size: 0.9rem;">Pending</div>
            </div>
            <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; border-top: 4px solid #3b82f6;">
                <div style="font-size: 2rem; font-weight: 700; color: #3b82f6;">
                    {{ $activities->where('status', 'In Progress')->count() }}
                </div>
                <div style="color: #6c757d; font-size: 0.9rem;">In Progress</div>
            </div>
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="content-card" style="text-align: center; padding: 60px 30px;">
        <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.3;">
            <i class="fas fa-tasks"></i>
        </div>
        <h2 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 15px; color: #2d3748;">
            No Activities Found
        </h2>
        <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 30px; line-height: 1.6;">
            @if(request('search'))
                No activities match your search criteria. Try different keywords or browse all activities.
            @else
                You haven't created any activities yet. Start organizing your tasks now!
            @endif
        </p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            @if(request('search'))
                <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> View All Activities
                </a>
            @endif
            <a href="{{ route('activities.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Your First Activity
            </a>
        </div>
    </div>
@endif

<!-- Edit Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 20px; padding: 30px; max-width: 600px; width: 90%; max-height: 80%; overflow-y: auto;">
        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 20px; color: #2d3748;">
            <i class="fas fa-edit"></i> Edit Activity
        </h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="editTitle">Title</label>
                <input type="text" id="editTitle" name="title" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="editDescription">Description</label>
                <textarea id="editDescription" name="description" class="form-input form-textarea" required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="editStatus">Status</label>
                <select id="editStatus" name="status" class="form-input" required>
                    <option value="">Select Status</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Done">Done</option>
                    <option value="Unfinished">Unfinished</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="editDueDate">Due Date</label>
                <input type="date" id="editDueDate" name="due_date" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label" for="editDeadline">Deadline (Tenggat Waktu)</label>
                <input type="datetime-local" id="editDeadline" name="deadline" class="form-input">
            </div>
            <div style="display: flex; gap: 15px; justify-content: end;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function showEditModal(id, title, description, status, dueDate, deadline) {
    document.getElementById('editModal').style.display = 'flex';
    document.getElementById('editForm').action = '/activities/' + id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDescription').value = description;
    document.getElementById('editStatus').value = status || 'Pending';
    document.getElementById('editDueDate').value = dueDate;
    document.getElementById('editDeadline').value = deadline ? deadline.replace(' ', 'T').substring(0, 16) : '';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Quick status update function
function updateActivityStatus(activityId, newStatus) {
    if (!newStatus) return;
    
    // Make AJAX request to update status
    fetch(`/activities/${activityId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to update status');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('Status updated successfully!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            throw new Error(data.error || 'Failed to update status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to update status. Please try again.', 'error');
    });
}

// Simple toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        background-color: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#007bff'};
    `;
    toast.textContent = message;
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(toast);
            document.head.removeChild(style);
        }, 300);
    }, 3000);
}
</script>
@endsection
