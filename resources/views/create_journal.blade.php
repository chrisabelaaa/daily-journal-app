@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="margin: 0 auto; max-width: 480px; padding: 2.5rem 2rem; background: #F2C4CD; border-radius: 1.25rem; box-shadow: 0 8px 32px rgba(5, 31, 69, 0.10); box-sizing: border-box;">
    <div class="dashboard-title" style="font-size: 2rem; font-weight: 700; color: #051F45; text-align: center; margin-bottom: 2rem;">Create Journal</div>
    <form method="POST" action="{{ route('journals.store') }}" style="display:flex; flex-direction:column; gap:1.5rem;">
        @csrf
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="title" style="color:#051F45; font-weight:600; font-size:1.05rem;">Title</label>
            <input type="text" id="title" name="title" required placeholder="Journal Title" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; outline:none; transition:border 0.2s; box-sizing: border-box;">
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="content" style="color:#051F45; font-weight:600; font-size:1.05rem;">Content</label>
            <textarea id="content" name="content" required placeholder="Write your journal..." rows="6" style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; outline:none; resize:vertical; transition:border 0.2s; box-sizing: border-box;"></textarea>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label for="status" style="color:#051F45; font-weight:600; font-size:1.05rem;">Status</label>
            <select id="status" name="status" required style="width:100%; padding:0.75rem 1rem; border:1.5px solid #051F45; border-radius:0.5rem; font-size:1rem; background:#fff; color:#051F45; outline:none; transition:border 0.2s; box-sizing: border-box;">
                <option value="">Select Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        <button type="submit" style="padding:0.95rem 1rem; background:#051F45; color:#F2C4CD; font-size:1.1rem; font-weight:700; border:none; border-radius:0.5rem; cursor:pointer; letter-spacing:0.5px; transition:background 0.2s;">Create</button>
    </form>
</div>
@endsection
