<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class PagesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index() {

    	$user_id = auth()->id();    	

    	$user = User::find($user_id);

    	$data = ['mylinks' => $user->links];

    	return view('pages.index')->with('data', $data);
    	
    }

}
