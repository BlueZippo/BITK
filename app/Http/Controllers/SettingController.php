<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Setting;
use App\Email;
use App\Mail\AddEmail;
use Illuminate\Support\Facades\Mail;

use Hash;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = User::find(auth()->id());

        $setting = $user->settings;

        $data['user'] = $user;

        $data['emails'] = $user->emails;

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
    public function change_password(Request $request)
    {
        $password = $request->get('password');

        $input['password'] = $password;
        $input['password_confirmation'] = Hash::make($password);

        User::find(auth()->id())->update($input);

        return ['success' => 1, 'message' => 'Password successfuly changed', 'title' => 'Success'];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addemail(Request $request)
    {
        $userid = auth()->id();

        $user = User::find($userid);

        $hasher = app('hash');

        $valid = false;

        $email = $request->get('email');

        if ($hasher->check($request->get('password'), $user->password)) 
        {
            $emails = Email::where('email', '=', $email)->where('confirmed','=', 1)->get();
            $users = User::where('email', '=', $email)->get();

            if ($emails->isEmpty() && $users->isEmpty())
            {
                $valid = true;
            }

            if ($valid)
            {  

                $code = $this->generateRandomString(50);

                $data['url'] = url('/settings/verify-email/' . $code);
                $data['name'] = $user->name;
                $data['email'] = $email;

                
                $newEmail = new Email;

                $newEmail->confirmation_code = $code;
                $newEmail->email = $email;
                $newEmail->user_id = $userid;
                $newEmail->notify = 1;

                $newEmail->save();                

                $content = new AddEmail($data);

                Mail::to('celsomalacasjr@gmail.com')->send($content);

                return ['success' => 1, 'message' => sprintf("Confirmation email sent to %s", $email)];

            }
            else
            {
                return ['error' => 'Email already exists in Platstack. Choose another email address.', 'title' => 'Invalid Email'];       
            }    
        }
        else
        {
            return ['error' => 'Incorrect password', 'title' => 'Invalid Password'];
        }
    }

    function generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $charactersLength = strlen($characters);
        
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
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
        
        $inbox_preference = $request->get('inbox_preference');

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
        
        $setting->inbox_preference = (int)$inbox_preference;

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


    public function verify_email($code)
    {
        $email = Email::where('confirmation_code', '=', $code)->first();

        if ($email)
        {
            $email->confirmed = 1;

            $email->save();

            return redirect('/dashboard');
        }   
        else
        {
            return redirect('/');
        } 
    }


    public function delete_email(Request $request)
    {
        $id = $request->get('id');

        $email = Email::find($id)->delete();

        return ['success' => 1, 'id' => $id];
    }

    public function confirm_email(Request $request)
    {
        $id = $request->get('id');

        $email = Email::find($id);

        $user = User::find($email->user_id);

        $code = $this->generateRandomString(50);

        $email->confirmation_code = $code;

        $email->notify = $email->notify + 1;

        $email->save();

        $data['url'] = url('/settings/verify-email/' . $code);
        $data['name'] = $user->name;
        $data['email'] = $email->email;

        $content = new AddEmail($data);       

        Mail::to('celsomalacasjr@gmail.com')->send($content); 

        return ['success' => 1, 'message' => sprintf("Confirmation email sent to %s", $email->email)];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function set_as_primary(Request $request)
    {
        $userid = auth()->id();

        $user = User::find($userid);

        $primary_email = $user->email;

        $email = $request->get('email');

        $valid = true;

        $hasher = app('hash');

        if ($hasher->check($request->get('password'), $user->password)) 
        { 

            $user->email = $email;

            $user->save();

            Email::where('email', $email)->where('user_id', $userid)->update(['email' => $primary_email]);

            if ($valid)
            {  

                return ['success' => 1, 'message' => sprintf("Primary email successfully change to %s", $email)];

            }
                
        }
        else
        {
            return ['error' => 'Incorrect password', 'title' => 'Invalid Password'];
        }
    }
}
