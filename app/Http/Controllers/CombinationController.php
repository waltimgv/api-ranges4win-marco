<?php

namespace App\Http\Controllers;

use App\CombinationMenu;
use App\CombinationTable;
use App\User;

class CombinationController extends Controller
{

    public function menus()
    {
        $menus = CombinationMenu::with(['submenus', 'submenus.links'])->get();
        return response()->json($menus);
    }

    public function table()
    {
        $table = CombinationTable::all();
        return response()->json($table);
    }

}
