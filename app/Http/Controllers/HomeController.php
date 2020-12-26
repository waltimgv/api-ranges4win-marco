<?php

namespace App\Http\Controllers;

use App\Plan;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([]);
    }

    public function plans()
    {
        $plans = Plan::query()->get(['number_days', 'description', 'price', 'currency']);
        return response()->json(compact('plans'));
    }
}
