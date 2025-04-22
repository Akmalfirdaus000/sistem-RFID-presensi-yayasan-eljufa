<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function user_dashboard()
    {
        return view('user.dashboard'); // Pastikan view ini ada di resources/views/dashboard/user.blade.php
    }
    public function admin_dashboard()
    {
        return view('admin.dashboard'); // Pastikan view ini ada di resources/views/dashboard/user.blade.php
    }
    
}
