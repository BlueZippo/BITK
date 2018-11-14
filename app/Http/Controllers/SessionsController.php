<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MediaType;
use App\Stack;

class SessionsController extends Controller {

    public function __construct() {

    	$this->middleware('guest', ['except' => 'destroy']);

    }

    public function create() 
    {
        $data['medias'] = MediaType::all();

        $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

        $data['options'] = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                    );


    	return view('sessions.create')->with($data);

    }

    public function store() {

    	if (! auth()->attempt( request(['email', 'password']) )) {
    		return back()->withErrors([
    			'message' => 'Please check your credentials and try again.'
    		]);
    	}

    	return redirect()->home();

    }

    public function destroy() {

    	auth()->logout();

    	return redirect()->home();

    }

}
