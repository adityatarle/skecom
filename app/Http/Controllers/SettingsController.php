<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        return view('admin.settings.general');
    }

    public function payment()
    {
        return view('admin.settings.payment');
    }

    public function email()
    {
        return view('admin.settings.email');
    }
}

