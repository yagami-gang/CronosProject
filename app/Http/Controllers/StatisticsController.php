<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function sales()
    {
        return view('administration.statistics.sales');
    }

    public function reservations()
    {
        return view('administration.statistics.reservations');
    }
}