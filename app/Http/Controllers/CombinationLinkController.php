<?php

namespace App\Http\Controllers;

use App\CombinationLink;
use App\Http\Requests\Link\StoreLinkRequest;
use App\Http\Requests\Link\UpdateLinkRequest;
use App\Plan;
use Illuminate\Http\Request;

class CombinationLinkController extends Controller
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
        $links = CombinationLink::all();
        return response()->json($links);
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
    public function store(StoreLinkRequest $request)
    {
        $link = CombinationLink::query()->create($request->validated());
        return response()->json(compact('link'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CombinationLink  $link
     * @return \Illuminate\Http\Response
     */
    public function show(CombinationLink $link)
    {
        return response()->json($link);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CombinationLink  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(CombinationLink $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CombinationLink $link
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLinkRequest $request, CombinationLink $link)
    {
        $updated = $link->update($request->validated());
        return response()->json(compact('updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CombinationLink $link
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(CombinationLink $link)
    {
        $link->delete();
        return response()->json();
    }
}
