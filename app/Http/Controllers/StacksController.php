<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Stack;
use App\StacksFollow;
use App\Category;
use App\user;
use App\Link;

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

    public function unfollow($id)
    {
        $user_id = auth()->id();

        $stack = StacksFollow::where('user_id', '=', $user_id)
                 ->where('stack_id', '=', $id);

        $stack->delete();        

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id));
    }

    public function dashboard($id)
    {
        $stack = Stack::find($id);

        $categories = array();

        $links = $stack->links;

        foreach($links as $link)
        {
           $cats = Link::find($link->id)->category->pluck('id')->toArray();

           $categories = array_merge($categories, $cats);
           
        }

        $categories = Category::whereIn('id', $categories)->get();

        $follows = User::find(auth()->id())
                   ->stacksFollow()
                   ->pluck('stack_id')
                   ->toArray();

        $mystack = User::find(auth()->id())
                   ->stacks()
                   ->get()
                   ->pluck('id')
                   ->toArray();                   

      

        $data['links'] = $links;

        $data['categories'] = $categories;

        $data['stack'] = $stack;     

        $data['follow'] = "";

        if (in_array($id, $follows))
        {    
            $data['follow'] = sprintf("<a class='follow-button' data-id='%s' data-action='%s'>%s</a>", $id, 'follow', 'UnFollow');      
        }
        else if (!in_array($id, $mystack))
        {
            $data['follow'] = sprintf("<a class='follow-button' data-id='%s' data-action='%s'>%s</a>", $id, 'follow', 'Follow');         
        } 

        return view('stacks.dashboard')->with($data);
    }

    public function explore()
    {

        $stacks = Stack::all();

        return view('stacks.explore')->with(['stacks' => $stacks]);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('search');

        $stacks = Stack::where("title", "LIKE", "%".$keywords."%")->get();

        return view('stacks.explore')->with(['stacks' => $stacks]);   
    }
    
}