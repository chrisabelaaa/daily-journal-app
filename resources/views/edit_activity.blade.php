@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="margin: 0 auto; max-width: 480px; padding: 2.5rem 2rem; background: #F2C4CD; border-radius: 1.25rem; box-shadow: 0 8px 32px rgba(5, 31, 69, 0.10); box-sizing: border-box;">
    <div class="dashboard-title" style="font-size: 2rem; font-weight: 700; color: #051F45; text-align: center; margin-bottom: 2rem;">Edit Activity</div>
    <form method="POST" action="{{ route('activities.update', $activity) }}" style="display:flex; flex-direction:column; gap:1.5rem;">
        @csrf
        @method('PUT')
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="title" style="color:#051F45; font-weight:600; font-size:1.05rem;">Title</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $activity->title) }}" placeholder="Activity Title" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="description" style="color:#051F45; font-weight:600; font-size:1.05rem;">Description</label>
            <textarea id="description" name="description" placeholder="Activity description..." rows="4" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; resize:vertical; transition:border 0.2s;">{{ old('description', $activity->description) }}</textarea>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="due_date" style="color:#051F45; font-weight:600; font-size:1.05rem;">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $activity->due_date) }}" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="deadline" style="color:#051F45; font-weight:600; font-size:1.05rem;">Deadline (Tenggat Waktu)</label>
            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline', $activity->deadline ? date('Y-m-d\TH:i', strtotime($activity->deadline)) : '') }}" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="status" style="color:#051F45; font-weight:600; font-size:1.05rem;">Status</label>
            <select id="status" name="status" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
                <option value="Pending" {{ old('status', $activity->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ old('status', $activity->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Done" {{ old('status', $activity->status) == 'Done' ? 'selected' : '' }}>Done</option>
                <option value="Unfinished" {{ old('status', $activity->status) == 'Unfinished' ? 'selected' : '' }}>Unfinished</option>
            </select>
        </div>
        <button type="submit" style="padding:0.95rem 1rem; background:#051F45; color:#F2C4CD; font-size:1.1rem; font-weight:700; border:none; border-radius:0.5rem; cursor:pointer; letter-spacing:0.5px; transition:background 0.2s;">Update</button>
    </form>
</div>
@endsection