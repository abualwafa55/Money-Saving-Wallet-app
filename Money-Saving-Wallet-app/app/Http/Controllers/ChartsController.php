<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartsController extends Controller
{
    //
    public function index()
    {
        $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May');
        $expenses  = array(1, 2, 3, 4, 5);
        $incomes  = array(2, 4, 5, 5, 4);
        return response()->json(['month' => $month, 'expenses' => $expenses, 'incomes'=>$incomes]);
    }
}
