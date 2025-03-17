<?php

namespace App\Http\Controllers;

use App\Models\KnowArea;
use App\Http\Requests\knowArea\StoreKnowAreaRequest;
use App\Http\Requests\knowArea\UpdateKnowAreaRequest;

class KnowAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $knowAreas = KnowArea::paginate();
        return response($knowAreas, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKnowAreaRequest $request)
    {
        $validated = $request->validated();
        $knowArea = KnowArea::create($validated);
        return response($knowArea, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KnowArea $knowArea)
    {
        return response($knowArea, 200);
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
        $knowArea->update($validated);
        return response($knowArea, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KnowArea $knowArea)
    {
        $knowArea->delete();
        return response(null, 204);
    }
}
