<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        // Auto-update status untuk activity yang deadline-nya terlewat
        Activity::where('user_id', auth()->id())
            ->where('status', '!=', 'Done')
            ->where('deadline', '<', now())
            ->whereNotNull('deadline')
            ->update(['status' => 'Unfinished']);
        
        // Jurnal = Activity dengan status 'Done' atau 'Unfinished' yang tidak diarsip
        $query = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->whereNull('archived_at');
        
        // Search berdasarkan judul atau tanggal
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereDate('created_at', $search);
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        $journals = $query->latest()->get();
        return view('my_journals', compact('journals'));
    }
    
    public function archived(Request $request)
    {
        // Jurnal yang diarsip
        $query = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->whereNotNull('archived_at');
        
        // Search berdasarkan judul atau tanggal
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereDate('created_at', $search);
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        $journals = $query->latest('archived_at')->get();
        return view('journals_archived', compact('journals'));
    }
    
    public function archive($id)
    {
        $activity = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->findOrFail($id);
        
        $activity->update(['archived_at' => now()]);
        
        return redirect()->route('journals.index')->with('status', 'Journal archived successfully!');
    }
    
    public function restore($id)
    {
        $activity = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->whereNotNull('archived_at')
            ->findOrFail($id);
        
        $activity->update(['archived_at' => null]);
        
        return redirect()->route('journals.archived')->with('status', 'Journal restored successfully!');
    }
    
    public function forceDelete($id)
    {
        $activity = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->whereNotNull('archived_at')
            ->findOrFail($id);
        
        $activity->forceDelete();
        
        return redirect()->route('journals.archived')->with('status', 'Journal permanently deleted!');
    }
    
    public function edit($id)
    {
        $journal = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->whereNull('archived_at')
            ->findOrFail($id);
        
        return view('edit_journal', compact('journal'));
    }
    
    public function update(Request $request, $id)
    {
        $journal = Activity::where('user_id', auth()->id())
            ->whereIn('status', ['Done', 'Unfinished'])
            ->whereNull('archived_at')
            ->findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'status' => 'required|in:Done,Unfinished',
        ]);
        
        $journal->update($validated);
        
        return redirect()->route('journals.index')->with('status', 'Journal updated successfully!');
    }

}
