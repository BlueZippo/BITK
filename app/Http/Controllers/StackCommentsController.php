<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\StackComments;
use App\Stack;
use Auth;

class StackCommentsController extends Controller
{

    public function __construct() 
    {

       $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new StackComments;

        $comment->user_id = auth()->id();
        $comment->comments = request('comment');
        $comment->stack_id = request('stack_id');

        $comment->save();

        $stack_id = request('stack_id');

        $stack = Stack::find($stack_id);

        $comments = $stack->comments()->limit(5)->orderby('updated_at', 'desc')->get();

        $data['stack_id'] = $stack_id;
        $data['stack'] = $stack;

        $data['comments'] = $comments;

        $html = view('stacks.comments-list')->with($data)->render();

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
