<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PeopleFollow;

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

        return view('people.index')->with('users', $users);
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
}
