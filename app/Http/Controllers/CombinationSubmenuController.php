<?php

namespace App\Http\Controllers;

use App\CombinationSubmenu;
use App\Http\Requests\Submenu\StoreSubmenuRequest;
use App\Http\Requests\Submenu\UpdateSubmenuRequest;

class CombinationSubmenuController extends Controller
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
        $submenus = CombinationSubmenu::query()->with('menu')->get();
        return response()->json($submenus);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubmenuRequest $request)
    {
        $submenu = CombinationSubmenu::query()->create($request->validated());
        return response()->json(compact('submenu'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CombinationSubmenu $submenu
     * @return \Illuminate\Http\Response
     */
    public function show(CombinationSubmenu $submenu)
    {
        $submenu->load(['links']);
        return response()->json($submenu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CombinationSubmenu $submenu
     * @return \Illuminate\Http\Response
     */
    public function edit(CombinationSubmenu $submenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CombinationSubmenu $submenu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubmenuRequest $request, CombinationSubmenu $submenu)
    {
        $updated = $submenu->update($request->validated());
        return response()->json(compact('updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CombinationSubmenu $submenu
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(CombinationSubmenu $submenu)
    {
        $submenu->delete();
        return response()->json();
    }
}
