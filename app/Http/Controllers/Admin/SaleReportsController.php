<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SaleReportsController extends Controller
{
    public function sales()
    {
        return view('admin.reports.sales.sales');
    }

    public function historySales()
    {
        return view('admin.reports.sales.history');
    }

    public function detailSales()
    {
        return view('admin.reports.sales.detail');
    }
}
