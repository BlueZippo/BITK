<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\User;
use App\MediaType;
use App\Stack;

use Spatie\Permission\Models\Role;

use DB;

use Hash;


class UserController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $data = User::orderBy('id','DESC')->paginate(5);

        return view('users.index',compact('data'))

            ->with('i', ($request->input('page', 1) - 1) * 5);

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|same:confirm-password',

            'roles' => 'required'

        ]);


        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')

                        ->with('success','User created successfully');

    }


    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $user = User::find($id);

        return view('users.show',compact('user'));

    }


    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {

        $user = User::find($id);

        $roles = Role::pluck('name','name')->all();

        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));

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

        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email,'.$id,

            'password' => 'same:confirm-password',

            'roles' => 'required'

        ]);


        $input = $request->all();

        if(!empty($input['password']))
        { 
            $input['password'] = Hash::make($input['password']);
        }
        else
        {
           $input = array_except($input,array('password'));   
        }    


        $user = User::find($id);

        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')

                        ->with('success','User updated successfully');

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {

        User::find($id)->delete();

        return redirect()->route('users.index')

                        ->with('success','User deleted successfully');

    }


    public function profile()
    {
        $user = User::find(auth()->id());

        $medias = MediaType::all();

        $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

        $options = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                    );

        return view('users.profile')->with(['user' => $user, 'medias' => $medias, 'options' => $options]);
    }


    public function profile_update(Request $request)
    {
        $this->validate($request, [

            'name' => 'required',
            'password' => 'same:password_confirmation',

        ]);

        $input = $request->all();


        if(!empty($input['password']))
        { 
            $input['password_confirmation'] = Hash::make($input['password']);

        }
        else
        {
            unset($input['password'], $input['password_confirmation']);
        }  

        
        $user = User::find(auth()->id());

        $user->update($input);

        return redirect()->route('users.profile')
                ->with('success', 'Profile updated');        


    }


    public function upload(Request $request)
    {

        $this->validate($request, [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $image = $request->file('image');

        $user_id = auth()->id();

        $photo = sprintf("photo-%s-%s.%s", $user_id, time(), $image->getClientOriginalExtension());

        $destinationPath = public_path('/upload');

        $image->move($destinationPath, $photo);

        $user = User::find($user_id);

        $input['photo'] = '/upload/' . $photo;

        $user->update($input);

        return json_encode(array('message'=> 'Image uploaded successfully', 'photo' => $input['photo']));
    }

    public function background(Request $request)
    {

        $this->validate($request, [

            'background' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $image = $request->file('background');

        $user_id = auth()->id();

        $photo = sprintf("background-%s-%s.%s", $user_id, time(), $image->getClientOriginalExtension());

        $destinationPath = public_path('/upload');

        $image->move($destinationPath, $photo);

        $user = User::find($user_id);

        $input['background'] = '/upload/' . $photo;

        $user->update($input);

        return json_encode(array('message'=> 'Image uploaded successfully', 'background' => $input['background']));
    }

}