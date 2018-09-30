<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\Stack;
use App\LinksFollow;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PagesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index() {

        $user_id = auth()->id();    	

        $mystacks = User::find($user_id)
    				->stacks()
    				->limit(3)
    				->orderBy('created_at', 'desc')
    				->get();

    	$stacks = Stack::orderBy('created_at', 'desc')
    			 ->where('user_id', '!=' , $user_id)
    			 ->get();			

    	$follows = 	User::find($user_id)
                    ->stacksFollow()
                    ->get();

        $tags = User::find($user_id)
                ->tags()
                ->get();

        $parking = User::find($user_id)                    
                   ->links()
                   ->get();

    	$data = ['mystacks' => $mystacks , 
                 'stacks' => $stacks, 
                 'follows' => $follows, 
                 'tags' => $tags, 
                 'parking' => $parking];

    	return view('pages.index')->with($data);
    	
    }

}
