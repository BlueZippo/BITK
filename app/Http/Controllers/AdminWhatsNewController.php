<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WhatsNew;

class AdminWhatsNewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin','permission:Admin']);
    }

    public function index()
    {
        return view('admin.whatsnew.index');
    }


    public function list()
    {
        $news = WhatsNew::orderBy('id','DESC')->get();

       
        $data = array();

        foreach($news as $new)
        {
            $data[] = array('id' => $new->id,
                            'title' => $new->title,
                            'date' => date("M d, Y H:i", strtotime($new->created_at)),
                            'author' => $new->user->name);
        }
        
        return response()->json($data);
        
    }

    
    public function create()
    {
        $html = view('admin.whatsnew.create')->render();        

        return response()->json(['html' => $html]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {
        $new = new WhatsNew;

        $new->title = $request->get('title');
        $new->content = $request->get('content');
        $new->user_id = auth()->id();

        $new->save();

        return response()->json(['success' => 1]);
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
        $new = WhatsNew::find($id);

        return response()->json($new);
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
        $new = WhatsNew::find($id);

        $new->title = request('title');
        $new->content = request('content');

        $new->save();

        return response()->json(['success' => 1]);
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
