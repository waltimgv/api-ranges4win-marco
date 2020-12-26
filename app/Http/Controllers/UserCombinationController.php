<?php

namespace App\Http\Controllers;

use App\CombinationLink;
use App\CombinationUser;
use App\Enums\CombinationType;
use App\Enums\Role;
use App\Http\Requests\Combination\CellsToCombinationRequest;
use App\Http\Requests\Combination\DestroyCombinationRequest;
use App\Http\Requests\Combination\FindUserCombinationRequest;
use App\Http\Requests\Combination\StoreUserCombinationRequest;
use App\Http\Requests\Combination\UpdateUserCombinationRequest;
use App\Instruction;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class UserCombinationController extends Controller
{

    public function __construct()
    {
        $this->middleware('linkIsPaid', ['except' => ['addCells', 'removeCells', 'update', 'destroy']]);
    }

    public function save(StoreUserCombinationRequest $request, User $user)
    {
        $combination = $user->combinations()->create($request->all());
        return response()->json($combination);
    }

    public function update(UpdateUserCombinationRequest $request, User $user, CombinationUser $combinationUser)
    {
        $combinationUser->update($request->all());
        return response()->json($combinationUser);
    }

    public function destroy(DestroyCombinationRequest $request, User $user, CombinationUser $combinationUser)
    {
        try {
            $combinationUser->delete();
            return response()->json();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function findByLink(FindUserCombinationRequest $request, User $user, CombinationLink $link)
    {
        $isPro = $request->get('type') === CombinationType::PRO;

        $instructions = Instruction::getFromLinkAndUser($link, $user, $isPro);
        $combinations = CombinationUser::getFromLinkAndUser($link, $user, $isPro);

        return response()->json(compact('combinations', 'instructions'));
    }

    public function addCells(CellsToCombinationRequest $request, User $user, CombinationUser $combinationUser)
    {
        $cells = collect($request->cells)->merge($combinationUser->cells)->unique('cell')->values()->toArray();

        $combinationUser->update(compact('cells'));
        return response()->json($combinationUser->cells);
    }

    public function removeCells(CellsToCombinationRequest $request, User $user, CombinationUser $combinationUser)
    {
        $cells = $request->cells;
        $combinationUser->update(compact('cells'));

        return response()->json($combinationUser->cells);
    }

}
