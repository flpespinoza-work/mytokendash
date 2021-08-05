<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserReportsController extends Controller
{
    public function newUsers()
    {
        return view('admin.reports.users.new');
    }

    public function history()
    {
        return view('admin.reports.users.history');
    }

    public function activity()
    {
        return view('admin.reports.users.activity');
    }
}
