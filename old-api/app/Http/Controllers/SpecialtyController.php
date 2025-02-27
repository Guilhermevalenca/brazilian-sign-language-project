<?php

namespace App\Http\Controllers;

use App\Http\Requests\specialty\StoreSpecialtyRequest;
use App\Http\Requests\specialty\UpdateSpecialtyRequest;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Specialty::paginate();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecialtyRequest $request)
    {
        $validated = $request->validated();
        $specialty = Specialty::create($validated);
        return response()->json($specialty, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialty $specialty)
    {
        return response()->json($specialty, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialty $specialty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialtyRequest $request, Specialty $specialty)
    {
        $validated = $request->validated();
        $specialty->update($validated);
        return response()->json($specialty, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return response()->json([
            "message" => "Specialty deleted successfully"
        ], 200);
    }
}
