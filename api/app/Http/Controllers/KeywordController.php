<?php

namespace App\Http\Controllers;

use App\Http\Requests\keyword\StoreKeywordRequest;
use App\Http\Requests\keyword\UpdateKeywordRequest;
use App\Models\Keyword;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Keyword::paginate();
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
    public function store(StoreKeywordRequest $request)
    {
        $validation = $request->validated();

        Keyword::create($validation);

        return response(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        return response($keyword, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keyword $keyword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKeywordRequest $request, Keyword $keyword)
    {
        $validation = $request->validated();

        $keyword->update($validation);

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        $keyword->delete();

        return response(null, 204);
    }
}
