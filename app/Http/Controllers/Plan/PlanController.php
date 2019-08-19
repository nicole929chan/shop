<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan\Plan;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function store(Request $request, Plan $plan)
    {
        $plan->add($request->member_id);
    }
}
