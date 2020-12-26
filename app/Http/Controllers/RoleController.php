<?php

namespace App\Http\Controllers;

use App\Enums\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return response()->json(Role::FORMATTED);
    }

}