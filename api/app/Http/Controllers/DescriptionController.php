<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescriptionRequest;
use App\Http\Requests\UpdateDescriptionRequest;
use App\Models\Description;
use App\Models\Sign;

class DescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return response(Description::paginate(), 200);
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
    public function store(StoreDescriptionRequest $request, Sign $sign)
    {
        $validated = $request->validated();

        $sign->description()->create($validated);

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Description $description)
    {
        return response($description, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Description $description)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDescriptionRequest $request, Description $description)
    {
        $validated = $request->validated();
        $description->update($validated);

        return response(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Description $description)
    {
        $description->delete();
    }
}
