<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MediaType;

class MediaTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['medias'] = MediaType::orderBy('media_type')->get();
        $data['i'] = 0;

        return view('media_types.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('media_types.create');
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

            'media_type' => 'required',


        ]);


        $media = new MediaType;

        $media->media_type = $request->input('media_type');

        $media->save();

        return redirect()->route('media_types.index')

                        ->with('success','Media type successfully');
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
        $media = MediaType::find($id);

        return view('media_types.edit',compact('media'));
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

            'media_type' => 'required'

        ]);  
        
        $media = MediaType::find($id);

        $media->update($request->all());       

        return redirect()->route('media_types.index')

                        ->with('success','Media type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MediaType::find($id)->delete();

        return redirect()->route('media_types.index')

                        ->with('success','Media type deleted successfully');
    }
}
