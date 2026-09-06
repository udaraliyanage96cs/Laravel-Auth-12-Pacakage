<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Illuminate\Http\Request;
use Udara\LaravelAuth\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        // Filter by User
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by Action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by Model Type
        if ($request->filled('model_type')) {
            $query->where('model_type', 'LIKE', "%{$request->model_type}%");
        }

        // Filter by Date Range
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereDate('created_at', '>=', trim($dates[0]))
                      ->whereDate('created_at', '<=', trim($dates[1]));
            } elseif (count($dates) === 1) {
                $query->whereDate('created_at', trim($dates[0]));
            }
        } else {
            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }
        }

        // Fetch logs with pagination
        $logs = $query->latest()->paginate(100);

        // Fetch unique actions and users for filtering
        $userModel = $this->getUserModel();
        $users = $userModel::select('id', 'name')->get();
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('activity_logs.index', compact('logs', 'users', 'actions'));
    }
}
