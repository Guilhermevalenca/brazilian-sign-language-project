<?php

namespace App\Http\Controllers;

use App\Http\Requests\keyword\StoreKeywordRequest;
use App\Http\Requests\keyword\UpdateKeywordRequest;
use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['required', 'string'],
        ]);
        $keywords = Keyword::where('name', 'like', '%' . $request->search . '%')
            ->with(['courses', 'subjects', 'signs'])
            ->first();
        return response($keywords, 200);
    }

    public function withFilters(Request $request) 
    {
        $request->validate([
            'search' => ['required', 'string'],
            'filterOptions' => ['required', 'array'],
            'filterOptions.courses' => ['required', 'boolean'],
            'filterOptions.subjects' => ['required', 'boolean'],
            'filterOptions.signs' => ['required', 'boolean'],
        ]);

        $keywords = Keyword::where('name', 'like', '%' . $request->search . '%');

        if(!$request->filterOptions['courses'] && !$request->filterOptions['subjects'] && !$request->filterOptions['signs']) {
            $keywords = $keywords->with(['courses', 'subjects', 'signs']);
        } else {
            if($request->filterOptions['courses']) {
                $keywords = $keywords->with('courses');
            }
            if($request->filterOptions['subjects']) {
                $keywords = $keywords->with('subjects');
            }
            if($request->filterOptions['signs']) {
                $keywords = $keywords->with('signs');
            }
        }

        return response($keywords->paginate(), 200);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        //
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
    public function update(Request $request, Keyword $keyword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        //
    }
}
