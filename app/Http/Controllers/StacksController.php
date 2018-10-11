<?php

namespace App\Http\Controllers;


use Validator;

use Illuminate\Http\Request;

use App\Stack;
use App\StacksFollow;
use App\Category;
use App\user;
use App\Link;
use App\StackLink;

class StacksController extends Controller {


    var $links = array();

    public function __construct() {

        $this->middleware('auth');

        //$this->middleware('permission:Subscriber');

        //$this->middleware('permission:stack-create', ['only' => ['create','store']]);

        //$this->middleware('permission:stack-edit', ['only' => ['edit','update']]);

        //$this->middleware('permission:stack-delete', ['only' => ['destroy']]);
    

    }

    public function create(Request $request) 
    { 
        $data['links'] = array();

        $data['user'] = User::find(auth()->id());

        if ($request->old('links'))
        {
            $data['links'] = $request->old('links');
        }    


        return view('stacks.create')->with($data);    	
    }
    
    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),
            [
             'title' => 'required',          
            ] 
        );

        if ($validator->fails()) 
        {
            return redirect('stacks/create')
                        ->withInput($request->all())
                        ->withErrors($validator);
        }
        
        $stack = new Stack;
        
        $stack->title = request('title');
        
        $stack->content = request('content');

        $stack->subtitle = request('subtitle');

        $stack->user_id = auth()->id();
        
        $stack->save();


        if ($request->has('links'))
        {
            $links = $request->input('links');

            foreach($links as $link)
            {
                $x = new Link;

                $x->title = $link['title'];
                $x->link = $link['url'];
                $x->description = $link['description'];
                $x->image = $link['image'];
                $x->user_id = auth()->id();

                $x->save();

                $xy = StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $x->id);

                $xy->delete();

                $xy = new StackLink;

                $xy->link_id = $x->id;
                $xy->stack_id = $stack->id;

                $xy->save();

            }    
        }    
        
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


    public function view_all()
    {
         $stacks = User::find(auth()->id())
                    ->stacks()
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('stacks.view-all', compact('stacks', $stacks));           
    }


    public function edit($id)
    {
        $stack = Stack::find($id);

        $data['stack'] = $stack;

        $data['user'] = User::find(auth()->id());

        $data['links'] = $stack->links;

        return view('stacks.edit')->with($data);              
    }


    public function update(Request $request, $id)
    {

        $stack = Stack::find($id);
        
        $stack->title = request('title');
        
        $stack->content = request('content');

        $stack->subtitle = request('subtitle');

        $stack->user_id = auth()->id();

        $stack->save();

        $links = StackLink::where('stack_id', '=', $stack->id)->get();

        foreach($links as $link)
        {
            $link_id = $link->link_id;

            Link::find($link_id)->delete();

            StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $link_id)->delete();
        }    


        if ($request->has('links'))
        {
            $links = $request->input('links');

            foreach($links as $link)
            {
                $x = new Link;

                $x->title = $link['title'];
                $x->link = $link['url'];
                $x->description = $link['description'];
                $x->image = $link['image'];
                $x->user_id = auth()->id();

                $x->save();

                $xy = StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $x->id);

                $xy->delete();

                $xy = new StackLink;

                $xy->link_id = $x->id;
                $xy->stack_id = $stack->id;

                $xy->save();

            }    
        }    

        return redirect('stacks/' .  $id . '/edit')->with('success', 'Stack updated');
    }
    
}