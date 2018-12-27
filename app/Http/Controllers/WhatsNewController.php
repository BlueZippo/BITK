<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WhatsNew;
use App\WhatsNewNotification;

class WhatsNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = WhatsNew::orderby('id', 'DESC')->limit(5)->get();

        $data = array();

        foreach($results as $result)
        {
            $data[] = array('title' => $result->title,
                            'content' => substr(strip_tags($result->content), 0, 200),
                            'id' => $result->id);
        }

        WhatsNewNotification::where('user_id', auth()->id())->where('last_viewed', date("Y-m-d"))->delete();

        $noti = new WhatsNewNotification;

        $noti->user_id = auth()->id();
        $noti->last_viewed = date("Y-m-d");

        $noti->save();


        return response()->json($data);
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
        $result = WhatsNew::find($id);

        $info['title'] = $result->title;
        $info['date'] = date("M d, Y", strtotime($result->created_at));
        $info['content'] = $result->content;
        $info['author'] = $result->user->name;

        $data['info'] = $info;

        $data['list'] = WhatsNew::orderby('id', 'desc')->limit(5)->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        $notification = 0;

        $user = WhatsNewNotification::orderby('last_viewed', 'desc')->where('user_id', auth()->id())->first();

        
        if ($user)
        {
            $results = WhatsNew::where('published_date', '>', $user->last_viewed)->get();
        }   
        else
        {
           $results = WhatsNew::all();
        }

        return response()->json(count($results));
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
