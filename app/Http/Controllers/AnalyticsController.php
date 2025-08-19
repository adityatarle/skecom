<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function sales()
    {
        return view('admin.analytics.sales');
    }

    public function products()
    {
        return view('admin.analytics.products');
    }

    public function customers()
    {
        return view('admin.analytics.customers');
    }
}

