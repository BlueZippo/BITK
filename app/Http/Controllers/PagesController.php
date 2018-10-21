<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\Stack;
use App\LinksFollow;
use App\StacksFollow;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PagesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index() {

        $user_id = auth()->id();

        $results = User::find($user_id)
    				->stacks()
    				->limit(3)
    				->orderBy('created_at', 'desc')
    				->get();

				$mystacks = array();

				foreach($results as $result)
				{
					$author = User::find($result->user_id);

					$categories = array();

					foreach($result->links as $link)
					{
						$categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
					}

					$follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

					$mystacks[] = array(
						    'id' => $result->id,
								'title' => $result->title,
								'content' => $result->content,
						    'image' => $result->video_id,
								'author' => $author,
								'follow' => $follow->isEmpty() ? false : true,
								'updated_at' => date("F d, Y", strtotime($result->updated_at)),
								'categories' => implode(',', array_unique($categories))
						);
				}



    		$results = Stack::orderBy('created_at', 'desc')
    			 ->where('user_id', '!=' , $user_id)
    			 ->get();


			  $follows = array();
				$stacks = array();

				foreach($results as $stack)
				{
					$user = User::find($stack->user_id);

					print_r($user);

					$author = array('name' => $user->name, 'email' => $user->email, 'photo' => $user->photo);

					$categories = array();

					foreach($stack->links as $link)
					{
						$categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
					}

					$follow = StacksFollow::where('stack_id', '=', $stack->id)->where('user_id', '=', auth()->id())->get();

					$stacks[] = array(
						    'id' => $stack->id,
								'title' => $stack->title,
								'content' => $stack->content,
						    'image' => $stack->video_id,
								'author' => $author,
								'follow' => $follow->isEmpty() ? false : true,
								'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
								'categories' => implode(',', array_unique($categories))
						);
				}

				return "";



    		$results = 	User::find($user_id)
                    ->stacksFollow()
                    ->get();

				foreach($results as $result)
				{
					$stack = Stack::find($result->stack_id);

					$author = User::find($result->user_id);

					$categories = array();

					foreach($stack->links as $link)
					{
						$categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
					}

					$follow = StacksFollow::where('stack_id', '=', $stack->id)->where('user_id', '=', auth()->id())->get();

					$follows[] = array(
						    'id' => $stack->id,
								'title' => $stack->title,
								'content' => $stack->content,
						    'image' => $stack->video_id,
								'author' => $author,
								'follow' => $follow->isEmpty() ? false : true,
								'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
								'categories' => implode(',', array_unique($categories))
						);
				}



        $tags = User::find($user_id)
                ->tags()
                ->get();


        $people = User::find($user_id)
                  ->peopleFollow()
                  ->get()
                  ->pluck('people_id');

        $people = User::whereIn('id', $people)->get();


        $parking = User::find($user_id)
                   ->links()
                   ->get();

    	$data = ['mystacks' => $mystacks ,
                 'stacks' => $stacks,
                 'follows' => $follows,
                 'tags' => $tags,
                 'people' => $people,
                 'user_id' => $user_id,
                 'parking' => $parking];

    	return view('pages.index')->with($data);

    }




}
