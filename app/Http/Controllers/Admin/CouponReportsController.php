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

    public function redeemed()
    {
        return view('admin.reports.coupons.redeemed');
    }

    public function lastPrinted()
    {
        return view('admin.reports.coupons.last-printed');
    }

    public function printedRedeemed()
    {
        return view('admin.reports.coupons.printed-redeemed');
    }

    public function detailRedeemed()
    {
        return view('admin.reports.coupons.detail-redeemed');
    }

    public function printedRedeemedHistory()
    {
        return view('admin.reports.coupons.printed-redeemed-history');
    }
}
