<?php

namespace App\Http\Controllers;

use App\Http\Requests\example\StoreExampleRequest;
use App\Http\Requests\example\UpdateExampleRequest;
use App\Models\Example;
use App\Models\Sign;

class ExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreExampleRequest $request, Sign $sign)
    {
        $validated = $request->validated();
        $sign->examples()->create($validated);

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Example $example)
    {
        return response($example, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Example $example)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExampleRequest $request, Example $example)
    {
        $validated = $request->validated();
        $example->update($validated);

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Example $example)
    {
        $example->delete();
        return response(null, 204);
    }
}
