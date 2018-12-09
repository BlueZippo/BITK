<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use App\Stack;
use App\MediaType;
use App\User;

class GlobalComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check())
        {

            $userid = Auth::user()->id;    

            $user = User::find($userid);

            $user_stacks = Stack::select('id as value', 'title as label')->where('user_id', '=', $userid)->get();

            $medias = MediaType::orderby('media_type')->get();

            $recents = Stack::select('id', 'title')->where('user_id', '=', $userid)->orderby('updated_at', 'desc')->limit(5)->get();

            $options = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', $userid)->orderBy('title')->get()->pluck('title','id')->toArray(),
                    );


            $unread = 0;

            $notifications = $user->notifications()->orderby('created_at', 'desc')->limit(15)->get();

            foreach($notifications as $notification)
            {
                if ($notification->status == 0)
                {
                    $unread++;
                }    
            }

            $view->with(['MyStacks' => $user_stacks, 
                         'mediaTypes' => $medias, 
                         'options' => $options, 
                         'notifications' => $notifications, 
                         'unread' => $unread]);

        }    
    }

}