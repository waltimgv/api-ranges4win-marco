<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateTermsUseRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        $updated = auth()->user()->update($request->all());
        return response()->json(['updated' => $updated]);
    }

    public function password(UpdatePasswordRequest $request)
    {
        $updated = auth()->user()->update(['password' => Hash::make($request->password)]);
        return response()->json(['updated' => $updated]);
    }

}