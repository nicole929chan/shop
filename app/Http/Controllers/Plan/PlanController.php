<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\PlanStoreRequest;
use App\Plan\Plan;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function store(PlanStoreRequest $request, Plan $plan)
    {
        $plan->add($request->member_id, $request->file('image'));

        return response()->json([
            'msg' => 'Joined successfully!'
        ], 200);
    }
}
