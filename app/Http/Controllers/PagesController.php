<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\Stack;
use App\LinksFollow;
use App\StacksFollow;
use App\StacksVote;
use App\MediaType;

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
    				->limit(4)
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

			$upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 1)->get();

			$downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 0)->get();

			$mystacks[] = array(
				    'id' => $result->id,
					'title' => $result->title,
					'content' => $result->content,
				    'image' => $result->video_id,
					'author' => $author,
					'upvotes' => $this->number_format(count($upvotes)),
					'downvotes' => $this->number_format(count($downvotes)),
					'user_id' => $result->user_id,
					'follow' => $follow->isEmpty() ? false : true,
					'updated_at' => date("F d, Y", strtotime($result->updated_at)),
					'categories' => implode(',', array_unique($categories))
				);
		}


    		$results = Stack::orderBy('created_at', 'desc')
    			 ->where('user_id', '!=' , $user_id)
    			 ->where('status_id', '=', 1)
    			 ->get();


			  $follows = array();
				$stacks = array();

				foreach($results as $stack)
				{
					$user = User::find($stack->user_id);

					if ($user)
					{

						$author = array('name' => $user->name, 'email' => $user->email, 'photo' => $user->photo);

						$categories = array();

						foreach($stack->links as $link)
						{
							$categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
						}

						$follow = StacksFollow::where('stack_id', '=', $stack->id)->where('user_id', '=', auth()->id())->get();

						$upvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=', 1)->get();

						$downvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=', 0)->get();

						$stacks[] = array(
							    'id' => $stack->id,
								'title' => $stack->title,
								'content' => $stack->content,
							    'image' => $stack->video_id,
								'author' => $author,
								'user_id' => $stack->user_id,
								'upvotes' => $this->number_format(count($upvotes)),
								'downvotes' => $this->number_format(count($downvotes)),
								'follow' => $follow->isEmpty() ? false : true,
								'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
								'categories' => implode(',', array_unique($categories))
							);

					}

				}



    		$results = 	User::find($user_id)
                    ->stacksFollow()
                    ->get();

				foreach($results as $result)
				{
					$stack = Stack::find($result->stack_id);

					$author = User::find($stack->user_id);


					if ($author && $stack->status_id == 1)
					{

						$categories = array();

						foreach($stack->links as $link)
						{
							$categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
						}

						$follow = StacksFollow::where('stack_id', '=', $stack->id)->where('user_id', '=', auth()->id())->get();

						$upvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=', 1)->get();

						$downvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=', 0)->get();

						$follows[] = array(
							    'id' => $stack->id,
								'title' => $stack->title,
								'content' => $stack->content,
							    'image' => $stack->video_id,
								'author' => $author,
								'user_id' => $stack->user_id,
								'upvotes' => $this->number_format(count($upvotes)),
								'downvotes' => $this->number_format(count($downvotes)),
								'follow' => $follow->isEmpty() ? false : true,
								'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
								'categories' => implode(',', array_unique($categories))
							);
					}

				}


		$user_stacks = Stack::select('id as value', 'title as label')->where('user_id', '=', auth()->id())->get();


		$recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();


        $tags = User::find($user_id)
                ->tags()
                ->get();


        $people = User::find($user_id)
                  ->peopleFollow()
                  ->get()
                  ->pluck('people_id')
                  ->toArray();

        $people = User::whereIn('id', $people)->get();

        $parking = User::find($user_id)
                   ->links()
                   ->where('stack_id', '=', 0)
                   ->get();

        $medias = MediaType::all();

         $options = array(
        			'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),        			  
        			'parking' => 'Parking Lot',
        			'new' => 'Create New Stack'
        			);

    	$data = ['mystacks' => $mystacks ,
                 'stacks' => $stacks,
                 'follows' => $follows,
                 'tags' => $tags,
                 'people' => $people,
                 'peopleFollows' => $people,
                 'user_id' => $user_id,
                 'medias' => $medias,
                 'options' => $options,
                 'MyStacks' => $user_stacks,
                 'parking' => $parking];

       

    	return view('pages.index')->with($data);

    }


    function number_format($num)
    {
        if($num > 1000) 
        {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;

        }

        return $num;
    
    }


}
