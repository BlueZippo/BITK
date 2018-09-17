<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Link;
use App\LinksFollow;

use DB;

class LinksController extends Controller
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
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        	[
        	 'title' => 'required',
        	 'link' => 'required'
        	] 
        );

       $link = new Link;

       $link->title = $request->input('title');
       $link->subtitle = $request->input('subtitle');
       $link->description = $request->input('description');
       $link->link = $request->input('link');
       $link->user_id = auth()->id();
       $link->save();

       return redirect('/')->with('success', 'Link Added');

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

    public function follow($id)
    {
    	$user_id = auth()->id();

    	$follow = new LinksFollow;

    	$follow->user_id = $user_id;
    	$follow->link_id = $id;

    	$follow->save();

    	return json_encode(array('user_id' => $user_id, 'link_id' => $id));
    }
}
