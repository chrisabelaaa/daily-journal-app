<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ActivityController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        // Auto-update status untuk activity yang deadline-nya terlewat
        Activity::where('user_id', auth()->id())
            ->where('status', '!=', 'Done')
            ->where('deadline', '<', now())
            ->whereNotNull('deadline')
            ->update(['status' => 'Unfinished']);
        
        // Hanya tampilkan activity yang belum masuk jurnal (belum Done atau Unfinished)
        $query = Activity::where('user_id', auth()->id())
            ->whereNotIn('status', ['Done', 'Unfinished']);
        
        // Search berdasarkan title atau description
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereDate('due_date', $search);
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        $activities = $query->latest()->get();
        return view('activity_list', compact('activities'));
    }

    public function create()
    {
        return view('create_activity');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'status' => 'required|string',
        ]);
        Activity::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'status' => $validated['status'],
        ]);
        return redirect()->route('activities.index')->with('status', 'Activity created successfully!');
    }

    public function edit(Activity $activity)
    {
        $this->authorize('update', $activity);
        return view('edit_activity', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $this->authorize('update', $activity);
        
        // Check if it's an AJAX request (status update only)
        if ($request->wantsJson() || $request->ajax()) {
            $validated = $request->validate([
                'status' => 'required|string',
            ]);
            $activity->update(['status' => $validated['status']]);
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'status' => $activity->status
            ]);
        }
        
        // Regular form update
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'status' => 'required|string',
        ]);
        $activity->update($validated);
        return redirect()->route('activities.index')->with('status', 'Activity updated successfully!');
    }

    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);
        $activity->delete();
        return redirect()->route('activities.index')->with('status', 'Activity deleted successfully!');
    }

    public function show(Activity $activity)
    {
        $this->authorize('view', $activity);
        return view('view_activity', compact('activity'));
    }
}
