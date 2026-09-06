<?php

namespace Udara\LaravelAuth\Http\Controllers;

use Illuminate\Http\Request;
use Udara\LaravelAuth\Models\Setting;

class WelcomeController extends Controller
{
    public function index()
    {
        $setting = Setting::latest()->first();
        return view('welcome', compact('setting'));
    }

    public function onPending(Request $request)
    {
        return view('user.on-pending');
    }
}
