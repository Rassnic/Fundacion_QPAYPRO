<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donacion;

class DashboardController extends Controller
{
    public function index()
    {
        $donaciones = Donacion::latest()->paginate(20);

        return view('admin.dashboard', compact('donaciones'));
    }
}
