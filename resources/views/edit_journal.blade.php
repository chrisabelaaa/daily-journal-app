@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="margin: 0 auto; max-width: 480px; padding: 2.5rem 2rem; background: #F2C4CD; border-radius: 1.25rem; box-shadow: 0 8px 32px rgba(5, 31, 69, 0.10); box-sizing: border-box;">
    <div class="dashboard-title" style="font-size: 2rem; font-weight: 700; color: #051F45; text-align: center; margin-bottom: 1.5rem;">Edit Journal</div>
    
    <!-- Success/Error Messages -->
    @if(session('status'))
    <div style="background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
        <i class="fas fa-check-circle"></i> {{ session('status') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
        <i class="fas fa-exclamation-circle"></i> 
        <strong>Please fix the following errors:</strong>
        <ul style="margin: 10px 0 0 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('journals.update', $journal->id) }}" style="display:flex; flex-direction:column; gap:1.5rem;">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="title" style="color:#051F45; font-weight:600; font-size:1.05rem;">Title</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $journal->title) }}" placeholder="Journal Title" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="description" style="color:#051F45; font-weight:600; font-size:1.05rem;">Description</label>
            <textarea id="description" name="description" placeholder="Journal description..." rows="6" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; resize:vertical; transition:border 0.2s;">{{ old('description', $journal->description) }}</textarea>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="due_date" style="color:#051F45; font-weight:600; font-size:1.05rem;">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $journal->due_date) }}" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="deadline" style="color:#051F45; font-weight:600; font-size:1.05rem;">Deadline (Tenggat Waktu)</label>
            <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline', $journal->deadline ? date('Y-m-d\TH:i', strtotime($journal->deadline)) : '') }}" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; box-sizing: border-box; outline:none; transition:border 0.2s;">
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="status" style="color:#051F45; font-weight:600; font-size:1.05rem;">Status</label>
            <select id="status" name="status" required style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; outline:none; transition:border 0.2s; box-sizing: border-box;">
                <option value="Done" {{ old('status', $journal->status) == 'Done' ? 'selected' : '' }}>Done</option>
                <option value="Unfinished" {{ old('status', $journal->status) == 'Unfinished' ? 'selected' : '' }}>Unfinished</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 15px;">
            <a href="{{ route('journals.index') }}" style="flex: 1; padding:0.95rem 1rem; background:#6c757d; color:#fff; font-size:1.1rem; font-weight:700; border:none; border-radius:0.5rem; text-align:center; text-decoration:none; letter-spacing:0.5px; transition:background 0.2s;">
                Cancel
            </a>
            <button type="submit" style="flex: 1; padding:0.95rem 1rem; background:#051F45; color:#F2C4CD; font-size:1.1rem; font-weight:700; border:none; border-radius:0.5rem; cursor:pointer; letter-spacing:0.5px; transition:background 0.2s;">
                Update Journal
            </button>
        </div>
    </form>
</div>
@endsection
