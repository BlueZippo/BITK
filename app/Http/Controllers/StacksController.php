<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Stack;
use App\StacksFollow;
use App\Category;

class StacksController extends Controller {

    public function __construct() {

        $this->middleware('auth');

        //$this->middleware('permission:Subscriber');

        //$this->middleware('permission:stack-create', ['only' => ['create','store']]);

        //$this->middleware('permission:stack-edit', ['only' => ['edit','update']]);

        //$this->middleware('permission:stack-delete', ['only' => ['destroy']]);
    

    }

    public function create() {

    	return view('stacks.create');
    	
    }
    
    public function store(Request $request) {
        
        //dd(request()->all());

        $this->validate($request,
            [
             'title' => 'required',          
            ] 
        );
        
        $stack = new Stack;
        
        $stack->title = request('title');
        
        $stack->content = request('content');

        $stack->subtitle = request('subtitle');

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


    public function follow($id)
    {
        $user_id = auth()->id();

        $stack = StacksFollow::where('user_id', '=', $user_id)
                 ->where('stack_id', '=', $id);

        $stack->delete();         

        $follow = new StacksFollow;

        $follow->user_id = $user_id;
        $follow->stack_id = $id;

        $follow->save();

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id));
    }

    public function dashboard($id)
    {
        $stack = Stack::find($id);

        $links = $stack->links;

        $categories = Category::get();

        $data['links'] = $links;

        $data['categories'] = $categories;

        $data['stack'] = $stack;           

        return view('stacks.dashboard')->with($data);
    }
    
}