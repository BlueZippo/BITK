<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Search;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = Search::first();

        $search_options = array();

        for($i=0; $i<=10; $i++) 
        {
            $options[] = $i;
        }

        $title = 0;
        $category = 0;
        $content = 0;
        $author = 0;
        $popularity = 0;
        $tags = 0;

        if ($search)
        {
            $title = $search->title;
            $category = $search->category;
            $content = $search->content;
            $author = $search->author;
            $popularity = $search->popularity;
            $tags = $search->tags;

        }    

        $data['title'] = $title;
        $data['content'] = $content;
        $data['category'] = $category;
        $data['author'] = $author;
        $data['tags'] = $tags;
        $data['popularity'] = $popularity;



        $data['search_options'] = $search_options;

        return view('search.index')->with($data);
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
    public function store(Request $request)
    {
        Search::truncate();

        Search::create($request->all());

         return redirect()->route('search.index')

                        ->with('success','Search algorithm updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
