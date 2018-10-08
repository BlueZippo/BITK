<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Link;
use App\LinksFollow;
use App\Stack;
use App\Category;
use App\LinkCategory;
use App\StackLink;
use App\User;

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
        $stacks = User::find(auth()->id())->stacks;

        $data['stacks'] = $stacks; 
        $data['categories'] = Category::get();

        return view('links.create')->with($data);
        
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

       if ($request->has('category'))
       {
        foreach($request->input('category') as $category_id)
        {
            $category = LinkCategory::where('category_id', '=', $category_id)->where('link_id', '=', $link->id);

            $category->delete();

            $category = new LinkCategory;

            $category->link_id = $link->id;
            $category->category_id = $category_id;

            $category->save();

        }
       } 

       if ($request->has('stack'))
       {
        foreach($request->input('stack') as $stack_id)
        {
            $stack = StackLink::where('stack_id', '=', $stack_id)->where('link_id', '=', $link->id);

            $stack->delete();

            $stack = new StackLink;

            $stack->link_id = $link->id;
            $stack->stack_id = $stack_id;

            $stack->save();

        }
       } 

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
        $link = Link::find($id);

        $stacks = User::find(auth()->id())->stacks;

        $data['stacks'] = $stacks; 

        $data['categories'] = Category::get();        
        
        $data['link'] = $link;

        return view('links.edit')->with($data);
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
        $link = Link::find($id);

        $link->title = $request->input('title');
        $link->subtitle = $request->input('subtitle');
        $link->description = $request->input('description');
        $link->link = $request->input('link');

       $link->save();

       if ($request->has('category'))
       {
        foreach($request->input('category') as $category_id)
        {
            $category = LinkCategory::where('category_id', '=', $category_id)->where('link_id', '=', $link->id);

            $category->delete();

            $category = new LinkCategory;

            $category->link_id = $link->id;
            $category->category_id = $category_id;

            $category->save();

        }
       } 

       if ($request->has('stack'))
       {
        foreach($request->input('stack') as $stack_id)
        {
            $stack = StackLink::where('stack_id', '=', $stack_id)->where('link_id', '=', $link->id);

            $stack->delete();

            $stack = new StackLink;

            $stack->link_id = $link->id;
            $stack->stack_id = $stack_id;

            $stack->save();

        }
       } 


        return redirect('/links/' . $id . '/edit')->with('success', 'Link updated');
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
