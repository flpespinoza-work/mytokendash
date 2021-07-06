<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BalanceReportsController extends Controller
{
    public function balance()
    {
        return view('admin.reports.balance.balance');
    }
}
