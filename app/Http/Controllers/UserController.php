<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Plan;
use App\PlanUser;
use App\CombinationUser;
use App\Services\UserPlanService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $userPlanService;

    public function __construct(UserPlanService $userPlanService)
    {
        $this->userPlanService = $userPlanService;
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        $password = ['password' => Hash::make($request->password)];
        $user = User::query()->create(array_merge($request->all(), $password));

        return response()->json($user);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $updated = $user->update($request->all());
        return response()->json(['updated' => $updated]);
    }

    public function destroy(User $user)
    {
        try {
            $this->handleDeleteUserData($user);

            $user->delete();

            return response()->json();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function plan(Request $request, User $user)
    {
        $plan = Plan::query()->findOrFail($request->plan);
        $planUser = $this->userPlanService->addPlanAsGift($plan, $user);

        return response()->json($planUser);
    }

    public function block(User $user)
    {
        $user->update(['is_blocked' => !$user->is_blocked]);
        return response()->json($user->is_blocked);
    }

    public function password(UpdatePasswordRequest $request, User $user)
    {
        $updated = $user->update(['password' => Hash::make($request->password)]);
        return response()->json(['updated' => $updated]);
    }

    private function handleDeleteUserData(User $user = null)
    {
        if (!$user) return;
        
        $planUser = PlanUser::query()->where("user_id", $user->id)->first();
        if ($planUser) {
            $planUser->delete();
        }

        $combinationUser = CombinationUser::query()->where("user_id", $user->id)->first();
        if ($combinationUser) {
            $combinationUser->delete();
        }
    }
}
