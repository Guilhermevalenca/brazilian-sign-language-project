<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithFiltersKeywordRequest;
use App\Models\Course;
use App\Models\Keyword;
use App\Models\Sign;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //buscando os 5 primeiros baseados na palavra chave
        $keywords = Keyword::select('id')->where('name', 'like', '%' . $request->search . '%')
            ->with([
                'courses' => function($query) {
                    $query->select('id', 'name')->take(5);
                }, 
                'subjects' => function($query) {
                    $query->select('id', 'name')->take(5);
                }, 
                'signs' => function($query) {
                    $query->select('id', 'name')->take(5);
                }
            ])
            ->first();

        //buscando mais 5 dados de cada, baseado no nome deles
        $courses = Course::where('name', 'like', '%' . $request->search . '%')
            ->select('id', 'name', DB::raw("'courses' as type"));

        $subjects = Subject::where('name', 'like', '%' . $request->search . '%')
            ->select('id', 'name', DB::raw("'subjects' as type"));

        $signs = Sign::where('name', 'like', '%' . $request->search . '%')
            ->select('id', 'name', DB::raw("'signs' as type"));

        $results = $courses->unionAll($subjects)
            ->unionAll($signs)
            ->orderBy('name')
            ->take(15)
            ->get()
            ->groupBy('type');

        return response($this->mergerKeywordsWithResults($keywords, $results), 200);
    }

    public function withFilters(WithFiltersKeywordRequest $request) 
    {
        $request->validated();

        $keywords = Keyword::select('id')->where('name', 'like', '%' . $request->search . '%');
        $courses = null;
        $subjects = null;
        $signs = null;

        if(!$request->filterOptions['courses'] && !$request->filterOptions['subjects'] && !$request->filterOptions['signs']) {
            $keywords = $keywords->with([
                'courses' => function($query) {
                    $query->select('id', 'name')->take(5);
                },
                'subjects' => function($query) {
                    $query->select('id', 'name')->take(5);
                }, 
                'signs' => function($query) {
                    $query->select('id', 'name')->take(5);
                }
            ]);

            $courses = Course::where('name', 'like', '%' . $request->search . '%')
                ->select('id', 'name', DB::raw("'courses' as type"));

            $subjects = Subject::where('name', 'like', '%' . $request->search . '%')
                ->select('id', 'name', DB::raw("'subjects' as type"));

            $signs = Sign::where('name', 'like', '%' . $request->search . '%')
                ->select('id', 'name', DB::raw("'signs' as type"));

        } else {
            if($request->filterOptions['courses']) {
                $keywords = $keywords->with([
                    'courses' => function($query) {
                        $query->select('id', 'name')->take(5);
                    },
                ]);
                $courses = Course::where('name', 'like', '%' . $request->search . '%')
                    ->select('id', 'name', DB::raw("'courses' as type"));
            }
            if($request->filterOptions['subjects']) {
                $keywords = $keywords->with([
                    'subjects' => function($query) {
                        $query->select('id', 'name')->take(5);
                    },
                ]);
                $subjects = Subject::where('name', 'like', '%' . $request->search . '%')
                    ->select('id', 'name', DB::raw("'subjects' as type"));
            }
            if($request->filterOptions['signs']) {
                $keywords = $keywords->with([ 
                    'signs' => function($query) {
                        $query->select('id', 'name')->take(5);
                    },
                ]);
                $signs = Sign::where('name', 'like', '%' . $request->search . '%')
                    ->select('id', 'name', DB::raw("'signs' as type"));
            }
        }

        $keywords = $keywords->paginate();
        $results = $courses->unionAll($subjects)
            ->unionAll($signs)
            ->orderBy('name')
            ->take(15)
            ->get()
            ->groupBy('type');

        
        $mergeResult = $this->mergerKeywordsWithResults($keywords->items()[0], $results);

        return response([
            'data' => $mergeResult,
            'last_page' => $keywords->lastPage(),
        ], 200);
    }

    //realizando merge das informações que vieram das palavras chaves e da segunda query
    private function mergerKeywordsWithResults($keywords, $results) {
        $mergedResults = [
            'courses' => [],
            'subjects' => [],
            'signs' => [],
        ];
    
        if ($keywords && $keywords->courses) {
            $mergedResults['courses'] = $keywords->courses->map(function ($course) {
                return ['id' => $course->id, 'name' => $course->name, 'type' => 'courses'];
            })->toArray();
        }
    
        if ($keywords && $keywords->subjects) {
            $mergedResults['subjects'] = $keywords->subjects->map(function ($subject) {
                return ['id' => $subject->id, 'name' => $subject->name, 'type' => 'subjects'];
            })->toArray();
        }
    
        if ($keywords && $keywords->signs) {
            $mergedResults['signs'] = $keywords->signs->map(function ($sign) {
                return ['id' => $sign->id, 'name' => $sign->name, 'type' => 'signs'];
            })->toArray();
        }

        foreach ($results as $type => $items) {
            foreach ($items as $key => $item) {
                $exists = collect($mergedResults[$type])->contains('id', $item->id);
                if (!$exists) {
                    //excluindo o campo type do item
                    $mergedResults[$type][] = [
                        'id' => $item->id,
                        'name' => $item->name,
                    ];
                }
            }
        }

        //removendo demais campos types
        foreach ($mergedResults as $type => $items) {
            foreach ($items as $key => $item) {
                $mergedResults[$type][$key] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];
            }
        }
        
        return $mergedResults;
    }

    public function create()
    {
        $keywords = Keyword::orderBy('name')->paginate();
        return response($keywords, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        Keyword::create([
            'name' => $request->name 
        ]);

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
