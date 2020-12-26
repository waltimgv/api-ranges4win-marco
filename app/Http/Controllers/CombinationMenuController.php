<?php

namespace App\Http\Controllers;

use App\CombinationMenu;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Plan;
use Illuminate\Http\Request;

class CombinationMenuController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = CombinationMenu::all();
        return response()->json($menus);
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
    public function store(StoreMenuRequest $request)
    {
        $menu = CombinationMenu::query()->create($request->validated());
        return response()->json(compact('menu'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CombinationMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(CombinationMenu $menu)
    {
        $menu->load(['submenus', 'submenus.links']);
        return response()->json($menu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CombinationMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(CombinationMenu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CombinationMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, CombinationMenu $menu)
    {
        $updated = $menu->update($request->validated());
        return response()->json(compact('updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CombinationMenu $menu
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(CombinationMenu $menu)
    {
        $menu->delete();
        return response()->json();
    }
}
