<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $setting = User::find(auth()->id())->settings;

        if ($setting)
        {    
            $data['setting'] = $setting;

        }
        else
        {
            $data['setting'] = new Setting;
        }

        return view('settings.index')->with($data);
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
    public function update(Request $request)
    {
        $userid = auth()->id();

        $user = User::find($userid);

        $allow_indexed_by_google = $request->get('allow_indexed_by_google');
        $allow_adult_content = $request->get('allow_adult_content');
        $all_any_person = $request->get('all_any_person');
        $allow_any_person_follow_send_messages = $request->get('allow_any_person_follow_send_messages');
        $allow_no_one = $request->get('allow_no_one');

        $activity_public_content = $request->get('activity_public_content');
        $activity_comments_and_replies = $request->get('activity_comments_and_replies');
        $mentions = $request->get('mentions');
        $new_messages = $request->get('new_messages');
        $timed_reminders = $request->get('timed_reminders');
        $upvotes = $request->get('upvotes');
        $new_followers = $request->get('new_followers');
        $stacks_following = $request->get('stacks_following');        
        $people_following = $request->get('people_following');
        

        Setting::where('user_id','=', $userid)->delete();

        $setting = new Setting;

        $setting->user_id = $userid;

        $setting->allow_indexed_by_google = (int)$allow_indexed_by_google;
        $setting->allow_adult_content = (int)$allow_adult_content;
        $setting->all_any_person = (int)$all_any_person;
        $setting->allow_any_person_follow_send_message = (int)$allow_any_person_follow_send_messages;
        $setting->allow_no_one = (int)$allow_no_one;

        $setting->activity_public_content = (int)$activity_public_content;
        $setting->activity_comments_and_replies = (int)$activity_comments_and_replies;
        $setting->mentions = (int)$mentions;
        $setting->new_messages = (int)$new_messages;
        $setting->timed_reminders = (int)$timed_reminders;
        $setting->upvotes = (int)$upvotes;
        $setting->new_followers = (int)$new_followers;
        $setting->stacks_following = (int)$stacks_following;
        $setting->people_following = (int)$people_following;
        

        $setting->save();

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
