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

use DB;
use Auth;

class ChromeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->id() > 0)
        {
            return $this->dashboard();
        }   
        else
        {
            $html = view('chrome.login.index')->render();

            return ['html' => $html];
        }    
    }


    public function login(Request $request)
    {
        if (! auth()->attempt( request(['email', 'password']) )) 
        {
            return ['html' => 'Please check your credentials and try again.'];
        }
        else
        {    
           $this->dashboard();
        }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user_id = auth()->id();

        $followers = array();   

        $user = User::find($user_id);

        $dashboard = $user->dashboard;

        $people = User::find($user_id)->peopleFollow()->get()->pluck('people_id')->toArray();

        $people_followers = User::find($user_id)->peopleFollow()->get()->pluck('user_id')->toArray();

        $stack_followers = StacksFollow::whereIn('stack_id', 
                                Stack::where('user_id', $user_id)
                                        ->get()
                                        ->pluck('id')
                                        ->toArray()
                                )
                                ->get()
                                ->pluck('user_id')
                                ->toArray();

        $results = User::find($user_id)
                    ->stacks()
                    ->limit(5)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $mystacks = array();

        $followed = StacksFollow::where('user_id', '=', auth()->id())->get()->pluck('stack_id')->toArray();
        $myStacks = Stack::where('user_id', '=', $user_id)->get()->pluck('id')->toArray();

        foreach($results as $result)
        {
            $author = User::find($result->user_id);

            $categories = array();

            foreach($result->links as $link)
            {
                $categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
            }

            //$follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 1)->get();

            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 0)->get();

            $mystacks[] = array(
                    'id' => $result->id,
                    'title' => $result->title,
                    'content' => $result->content,
                    'image' => $result->video_id,
                    'author' => $author,
                    'media_type' => $result->media_type,
                    'upvotes' => $this->number_format(count($upvotes)),
                    'downvotes' => $this->number_format(count($downvotes)),
                    'user_id' => $result->user_id,
                    'follow' => in_array($result->id, $followed) ? true : false,
                    'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                    'categories' => implode(',', array_unique($categories))
                );
        }


        $results = Stack::orderBy('created_at', 'desc')
             ->whereNotIn('id', array_merge($followed, $myStacks))
             ->where('status_id', '=', 1)
             ->where('private', '=', 0)
             ->limit(12)
             ->get();


        $follows = array();
        $stacks = array();

        foreach($results as $stack)
        {
            $user = User::find($stack->user_id);

            if ($user)
            {
                $author = array('name' => $user->name, 
                                'email' => $user->email, 
                                'photo' => $user->photo, 
                                'id' => $user->id, 
                                'followed' => ($user->id == $user_id || in_array($user->id, $people))  ? 1 : 0
                            );

                $categories = array();

                foreach($stack->links as $link)
                {
                    $categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
                }

                //$follow = StacksFollow::where('stack_id', '=', $stack->id)->where('user_id', '=', auth()->id())->get();

                $upvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=', 1)->get();

                $downvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=', 0)->get();

                $stacks[] = array(
                        'id' => $stack->id,
                        'title' => $stack->title,
                        'content' => $stack->content,
                        'image' => $stack->video_id,
                        'author' => $author,
                        'user_id' => $stack->user_id,
                        
                        'media_type' => $stack->media_type,
                        'upvotes' => $this->number_format(count($upvotes)),
                        'downvotes' => $this->number_format(count($downvotes)),
                        'follow' => in_array($stack->id, $followed) ? true : false,
                        'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
                        'categories' => implode(',', array_unique($categories))
                    );

            }

        }
    

            

        $results =  Stack::whereIn('id', $followed)
                        ->where('status_id','=',1)
                        ->where('private','=',0)
                        ->get();


        foreach($results as $result)
        {
            $stack = $result;

            if ($stack)
            {

                $user = User::find($stack->user_id);

                $valid = false;

                if ($user)
                {       

                    $author = array('name' => $user->name, 
                                'email' => $user->email, 
                                'photo' => $user->photo, 
                                'id' => $user->id, 
                                'followed' => ($user->id == $user_id || in_array($user->id, $people))  ? 1 : 0
                            );

                    $valid = true;

                }

                if ($stack->user_id == auth()->id())
                {
                    $valid = false;
                }   

                if ($valid && $stack->status_id == 1)
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
                            'followed' => true,
                            'user_id' => $stack->user_id,
                            'media_type' => $stack->media_type,
                            'upvotes' => $this->number_format(count($upvotes)),
                            'downvotes' => $this->number_format(count($downvotes)),
                            'follow' => $follow->isEmpty() ? false : true,
                            'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
                            'categories' => implode(',', array_unique($categories))
                        );
                }
            }

        }


        


        $tags = User::find($user_id)
                ->tags()
                ->get();


        $people = User::find($user_id)
                  ->peopleFollow()
                  ->get()
                  ->pluck('people_id')
                  ->toArray();

        $people = User::whereIn('id', $people)->get();

        $followers = User::whereIn('id', array_merge($people_followers, $stack_followers))->get();

        $parking = User::find($user_id)
                   ->links()
                   ->where('stack_id', '=', 0)
                   ->get();

        $medias = MediaType::all();

        $data = ['mystacks' => $mystacks ,
                 'stacks' => $stacks,
                 'follows' => $follows,
                 'tags' => $tags,
                 'people' => $people,
                 'peopleFollows' => $people,
                 'user_id' => $user_id,
                 'followers' => $followers,
                 'dashboard' =>json_decode($dashboard),
                 'parking' => $parking];

       

        $html =  view('chrome.dashboard')->with($data)->render();

        return ['html' => $html];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
