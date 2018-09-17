<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\LinksFollow;

class PagesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index() {

    	$user_id = auth()->id();    	

    	$mylinks = User::find($user_id)
    				->links()
    				->limit(3)
    				->orderBy('created_at', 'desc')
    				->get();

    	$links = Link::orderBy('created_at', 'desc')
    			 ->where('user_id', '!=' , $user_id)
    			 ->get();			

    	$follows = 	User::find($user_id)
    				->linksFollow($user_id)
    				->get();

    	$data = ['mylinks' => $mylinks , 'links' => $links, 'follows' => $follows];

    	return view('pages.index')->with('data', $data);
    	
    }

}
