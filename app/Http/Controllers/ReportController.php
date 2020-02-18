<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportClientUse()
    {
        return view('reports.ClientUse');
    }
    public function reportClientReading()
    {
         return view('reports.ClientReading');
    }
}
