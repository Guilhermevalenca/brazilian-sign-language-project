<?php

namespace App\Http\Controllers;

use App\Http\Requests\know_area\StoreKnowAreaRequest;
use App\Http\Requests\know_area\UpdateKnowAreaRequest;
use App\Models\KnowArea;

class KnowAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KnowArea::paginate();
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
    public function store(StoreKnowAreaRequest $request)
    {
        $validated = $request->validated();

        $knowarea = Knowarea::create($validated);

        return response()->json($knowarea, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowArea $knowArea)
    {
        return response()->json($knowArea, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KnowArea $knowArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKnowAreaRequest $request, KnowArea $knowArea)
    {
        $validated = $request->validated();
        $knowArea->update($request->all());
        return response()->json($knowArea, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnowArea $knowArea)
    {
        $knowArea->delete();
        return response()->json([
            "message" => "KnowArea deleted successfully"
        ], 204);
    }
}
