<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function stats($campaign)
    {
        return view('admin.notifications.stats', ['campaign' => $campaign]);
    }
}
