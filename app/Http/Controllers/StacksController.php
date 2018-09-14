<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Stack;

class StacksController extends Controller {

    public function __construct() {

        $this->middleware('auth');

    }

    public function create() {

    	return view('stacks.create');
    	
    }
    
    public function store() {
        
        //dd(request()->all());
        
        $stack = new Stack;
        
        $stack->title = request('title');
        
        $stack->content = request('content');

        $stack->user_id = auth()->id();

        /*
        Stack::create([

            'title' => request('title'),

            'content' => request('content'),

            'user_id' => Auth::user()->getId()

        ]);
        */
        
        
        $stack->save();
        
        return redirect()->home();
        
    }
    
}