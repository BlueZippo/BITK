<?php

namespace App\Http\Controllers;

use Validator;


use Illuminate\Http\Request;

use App\LinkParser;
use App\MediaType;

class AdminLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = array('Select');

        foreach(MediaType::orderby('media_type')->get() as $media)
        {
            $categories[$media->id] = $media->media_type;
        }    

        $data['CATEGORIES'] = $categories;

        return view('admin.links.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
             'domain' => 'required',
             'image' => 'required',
             'title' => 'required',
             'description' => 'required'
            ]
        );

        if ($validator->fails())
        {
            return redirect('admin/links/create')
                        ->withInput($request->all())
                        ->withErrors($validator);
        }


        $parser = new LinkParser;

        $parser->domain = request('domain');
        $parser->title = request('title');
        $parser->description = request('description');
        $parser->image = request('image');
        $parser->category = request('category');
        $parser->lookup = request('lookup');

        $parser->save();
        
        return redirect('admin/links/parser');
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
        $categories = array('Select');

        foreach(MediaType::orderby('media_type')->get() as $media)
        {
            $categories[$media->id] = $media->media_type;
        }    

        $data['CATEGORIES'] = $categories;
        $data['link'] = LinkParser::find($id);

        return view('admin.links.edit')->with($data);
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
        $validator = Validator::make($request->all(),
            [
             'domain' => 'required',
             'image' => 'required',
             'title' => 'required',
             'description' => 'required'
            ]
        );

        if ($validator->fails())
        {
            return redirect('admin/links/'.$id.'edit')
                        ->withInput($request->all())
                        ->withErrors($validator);
        }


        $parser = LinkParser::find($id);

        $parser->domain = request('domain');
        $parser->title = request('title');
        $parser->description = request('description');
        $parser->image = request('image');
        $parser->category = request('category');
        $parser->lookup = request('lookup');

        $parser->save();
        
        return redirect('admin/links/parser');
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


    public function parser()
    {
        $links = LinkParser::orderby('domain')->get();

        $data['links'] = $links;

        return view('admin.links.parser')->with($data);
    }
}
