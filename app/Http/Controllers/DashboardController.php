<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $datas = Document::with('user')->get();

        return view('dashboard')->with('datas', $datas);
    }
}
