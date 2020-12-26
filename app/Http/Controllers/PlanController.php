<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plan\StorePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Plan;
use App\PlanUser;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{

    private $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->middleware('admin', ['except' => ['index']]);

        $this->payPalService = $payPalService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::all();
        return response()->json($plans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlanRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $plan = $this->payPalService->createPlan($request->all())->save();
            return response()->json(compact('plan'));
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return response()->json($plan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        return DB::transaction(function () use ($request, $plan) {
            $updated = $this->payPalService->updatePlan($plan, $request->all())->save();
            return response()->json(compact('updated'));
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        return DB::transaction(function () use ($plan) {
            $this->deletePlanUsersOfAPlan($plan);

            $plan->delete();
            return response()->json();
        });
    }

    private function deletePlanUsersOfAPlan(Plan $plan = null)
    {
        if (!$plan) return;

        $planUsers = PlanUser::query()->where("plan_id", $plan->id)->get();
        if (!$planUsers || $planUsers->count() === 0) return;

        foreach ($planUsers as $planUser) {
            $planUser->delete();
        }
    }
}
