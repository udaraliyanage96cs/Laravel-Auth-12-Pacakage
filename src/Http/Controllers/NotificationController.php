<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Udara\LaravelAuth\Notifications\SystemNotification;
use Udara\LaravelAuth\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $req)
    {
        $notifications = auth()->user()->notifications;
        $userModel = $this->getUserModel();
        $users = $userModel::whereNotNull('email_verified_at')->get();
        return view('notifications.index', compact('notifications', 'users'));
    }

    public function testNotifications(Request $req)
    {
        $userModel = $this->getUserModel();
        $user = $userModel::first();
        if ($user) {
            $data = [
                'title' => "This is a new sample message",
                'message' => "This is a new sample message",
                'sender' => Auth::user(),
            ];
            $user->notify(new SystemNotification($data));
        }
        return response()->json(['message' => 'This is a test method']);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification && $notification->notifiable_id == auth()->id()) {
            $notification->markAsRead();
        }
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $userModel = $this->getUserModel();
        $users = $userModel::whereIn('id', $request->users)->get();
        $data = [
            'title' => $request->title,
            'message' => $request->message,
            'sender' => Auth::user(),
        ];
        foreach ($users as $user) {
            $user->notify(new SystemNotification($data));
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => "Notification has been sent",
            'model_type' => $userModel,
            'model_id' => 0
        ]);

        return back()->with('success', 'Notifications sent successfully!');
    }
}
