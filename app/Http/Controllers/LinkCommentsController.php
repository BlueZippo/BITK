<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Link;
use App\LinkComment;
use Auth;
use DB;

class LinkCommentsController extends Controller
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
        $comment = new LinkComment;

        $comment->user_id = auth()->id();
        $comment->comments = request('comment');
        $comment->link_id = request('link_id');

        $comment->save();

        $link_id = request('link_id');

        $link = Link::find($link_id);

        $comments = $link->comments()->limit(5)->orderby('updated_at', 'desc')->get();

        $data['link_id'] = $link_id;
        $data['stack'] = $link;

        $data['comments'] = $comments;

        $html = view('links.comments-list')->with($data)->render();

        return ['html' => $html];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['link_id'] = $id;

        $link = Link::find($id);

        $comments = $link->comments()->limit(5)->orderby('updated_at', 'desc')->get();

        $data['comments'] = $comments;

        $html = view('links.comments')->with($data)->render();

        return ['html' => $html];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
