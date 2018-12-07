<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PeopleFollow;
use App\Stack;
use App\StacksFollow;
use App\StacksVote;
use App\StackComments;
use App\MediaType;
use App\StacksFavorite;
use App\Notification;

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

        $medias = MediaType::all();

        $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

        $options = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                    );

        return view('people.index')->with(['users' => $users,
                                           'peopleFollows' => $follows,
                                           'medias' => $medias,
                                           'options' => $options]);
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

        $noti = new Notification;

        $noti->user_id = $id;
        $noti->action = 'follow';
        $noti->type = 'people';
        $noti->item_id = $id;
        $noti->person_id = $user_id;

        $noti->save();


        return json_encode(array('user_id' => $user_id, 'people_id' => $id, 'action' => 'follow'));
    }

    public function unfollow($id)
    {
        $user_id = auth()->id();

        $people = PeopleFollow::where('user_id', '=', $user_id)
                 ->where('people_id', '=', $id);

        $people->delete();

        return json_encode(array('user_id' => $user_id, 'people_id' => $id, 'action' => 'unfollow'));
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

            $favorite = StacksFavorite::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',0)->get();;

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',1)->get();;

            $comments = StackComments::where('stack_id', '=', $result->id)->get();

            $stacks[] = array(
                    'id' => $result->id,
                    'title' => $result->title,
                    'content' => $result->content,
                    'image' => $result->video_id,
                    'media_type' => $result->media_type,
                    'author' => $author,
                    'follow' => $follow->isEmpty() ? false : true,
                    'favorite' => $favorite->isEmpty() ? false : true,
                    'upvotes' => count($upvotes),
                    'downvotes' => count($downvotes),
                    'comments' => count($comments),
                    'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                    'categories' => implode(',', array_unique($categories))
                );
        }

        return view('people.stacks')->with(['user' => $user, 'stacks' => $stacks]);
    }

    public function person($id) {

        $user = User::find($id);

        $stacks = array();

        //$stacks = DB::table('stacks')->where('user_id', '=', $id)->get();

        //$stacks = Stack::where('user_id', '=', $id)->get();

        $results = Stack::where('user_id', '=', $id)->orderby('updated_at', 'desc')->get();

        foreach($results as $result) {

            $stacks[] = array(
                'title' => $result->title,
                'created' => $result->created_at,
                'updated' => $result->updated_at,
                'media' => $result->video_id,
            );

        }

        return view('people.person')->with(['user' => $user, 'stacks' => $stacks]);

    }
}
