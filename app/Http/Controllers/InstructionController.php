<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instruction\DestroyInstructionRequest;
use App\Http\Requests\Instruction\StoreInstructionRequest;
use App\Http\Requests\Instruction\UpdateInstructionRequest;
use App\Instruction;
use Illuminate\Http\Response;

class InstructionController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $instructions = Instruction::all();
        return response()->json($instructions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreInstructionRequest $request
     * @return Response
     */
    public function store(StoreInstructionRequest $request)
    {
        $attributes = collect($request->validated())->put('user_id', auth()->user()->id);
        $instruction = Instruction::query()->create($attributes->toArray());
        return response()->json(compact('instruction'));
    }

    /**
     * Display the specified resource.
     *
     * @param Instruction $instruction
     * @return Response
     */
    public function show(Instruction $instruction)
    {
        $instruction->load(['link', 'link.submenu', 'link.submenu.menu']);
        return response()->json($instruction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Instruction $instruction
     * @return Response
     */
    public function edit(Instruction $instruction)
    {
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInstructionRequest $request
     * @param Instruction $instruction
     * @return Response
     */
    public function update(UpdateInstructionRequest $request, Instruction $instruction)
    {
        $updated = $instruction->update($request->validated());
        return response()->json(compact('updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyInstructionRequest $request
     * @param Instruction $instruction
     * @return Response
     * @throws \Exception
     */
    public function destroy(DestroyInstructionRequest $request, Instruction $instruction)
    {
        $instruction->delete();
        return response()->json();
    }
}
