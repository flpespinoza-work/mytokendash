<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class CouponReportsController extends Controller
{
    public function printed()
    {
        return view('admin.reports.coupons.printed');
    }
}
