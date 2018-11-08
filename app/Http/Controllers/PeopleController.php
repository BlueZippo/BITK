<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PeopleFollow;
use App\Stack;
use App\StacksFollow;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $follows = User::find(auth()->id())
                    ->peopleFollow()
                    ->pluck('people_id');            

        return view('people.index')->with(['users' => $users, 'peopleFollows' => $follows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function follow($id)
    {
        $user_id = auth()->id();

        $people = PeopleFollow::where('user_id', '=', $user_id)
                 ->where('people_id', '=', $id);

        $people->delete();         

        $follow = new PeopleFollow;

        $follow->user_id = $user_id;
        $follow->people_id = $id;

        $follow->save();

        return json_encode(array('user_id' => $user_id, 'people_id' => $id));
    }

    public function unfollow($id)
    {
        $user_id = auth()->id();

        $people = PeopleFollow::where('user_id', '=', $user_id)
                 ->where('people_id', '=', $id);

        $people->delete();    

        return json_encode(array('user_id' => $user_id, 'people_id' => $id));
    }

    public function stacks($user_id)
    {
        $user = User::find($user_id);

        $stacks = array();

        foreach($user->stacks as $result)
        {
            $author = User::find($result->user_id);

            $categories = array();

            foreach($result->links as $link)
            {
                $categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
            }

            $follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',0)->get();;

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',1)->get();;

            $comments = StackComments::where('stack_id', '=', $result->id)->get();

            $stacks[] = array(
                    'id' => $result->id,
                    'title' => $result->title,
                    'content' => $result->content,
                    'image' => $result->video_id,
                    'author' => $author,
                    'follow' => $follow->isEmpty() ? false : true,
                    'upvotes' => count($upvotes),
                    'donwvotes' => count($downvotes),
                    'comments' => count($comments),
                    'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                    'categories' => implode(',', array_unique($categories))
                );
        }

        return view('people.stacks')->with(['user' => $user, 'stacks' => $stacks]);
    }
}
