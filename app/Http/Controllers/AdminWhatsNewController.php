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
        $results = WhatsNew::orderBy('id','DESC')->get();

        $data = array('results' => array());

        foreach($results as $result)
        {
            $result['published_date'] = date("m/d/Y", strtotime($result->published_date));

            $data['results'][] = $result;
        }

        return view('admin.whatsnew.index')->with($data);
    }


    public function list()
    {
        $news = WhatsNew::orderBy('id','DESC')->get();
       
        $data = array();

        foreach($news as $new)
        {
            $data[] = array('id' => $new->id,
                            'title' => $new->title,
                            'type' => $new->type == 'whatsnew' ? "What's New" : "News",
                            'date' => date("M d, Y H:i", strtotime($new->published_date)),
                            'author' => $new->user->name);
        }
        
        return response()->json($data);
        
    }

    
    public function create()
    {
        $html = view('admin.whatsnew.create')->render();        

        return response()->json(['html' => $html]);

    }

    public function add()
    {
        $data['date'] = date("m/d/Y");

        return view('admin.whatsnew.create')->with($data);
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

        list($m, $d, $y) = explode("/", $request->get('published_date'));

        $new->title = $request->get('title');
        $new->content = $request->get('content');
        $new->published_date = sprintf("%s-%s-%s", $y, $m, $d);
        $new->subtitle = $request->get('subtitle');
        $new->excerpt = $request->get('excerpt');
        $new->type = $request->get('type');
        $new->user_id = auth()->id();

        $new->save();

        //return response()->json(['success' => 1]);

        return redirect()->route('admin.whatsnew'); 
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

        $new->published_date = date("m/d/Y", strtotime($new->published_date));

        $data['new'] = $new;

        return view('admin.whatsnew.edit')->with($data);

        //return response()->json($new);
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

        list($m, $d, $y) = explode("/", $request->get('published_date'));

        $new->title = request('title');
        $new->content = request('content');
        $new->published_date = sprintf("%s-%s-%s", $y, $m, $d);
        $new->subtitle = $request->get('subtitle');
        $new->excerpt = $request->get('excerpt');
        $new->type = $request->get('type');

        $new->save();

        return redirect()->route('admin.whatsnew'); 

        //return response()->json(['success' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id');

        WhatsNew::find($id)->delete();

        return response()->json(['success' => 1]);
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');

        WhatsNew::find($id)->delete();

        return response()->json(['success' => 1]);
    }
}
