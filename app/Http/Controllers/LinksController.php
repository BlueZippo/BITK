<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Link;
use App\LinksFollow;
use App\Stack;
use App\Category;
use App\LinkCategory;
use App\StackLink;
use App\User;
use App\Reminder;

use DB;

class LinksController extends Controller
{

    public function __construct() {

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stacks = User::find(auth()->id())->stacks;

        $data['stacks'] = $stacks;
        $data['categories'] = Category::get();
        $data['links'] = array();

        return view('links.create')->with($data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        	[
        	 'link_title' => 'required',
        	 'link_url' => 'required'
        	]
        );

       $link = new Link;

       $link->title = $request->input('link_title');
       $link->description = $request->input('link_description');
       $link->link = $request->input('link_url');
       $link->stack_id = $request->input('stack_id');
       $link->media_id = $request->input('media_id');
       $link->image = $request->input('link_image');

       $link->user_id = auth()->id();

       $link->save();



      return ["Success"];

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
        $link = Link::find($id);

        $stacks = User::find(auth()->id())->stacks;

        $data['stacks'] = $stacks;

        $data['categories'] = Category::get();

        $data['link'] = $link;

        return view('links.edit')->with($data);
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
        $link = Link::find($id);

        $link->title = $request->input('title');
        $link->subtitle = $request->input('subtitle');
        $link->description = $request->input('description');
        $link->link = $request->input('link');

       $link->save();

       if ($request->has('category'))
       {
        foreach($request->input('category') as $category_id)
        {
            $category = LinkCategory::where('category_id', '=', $category_id)->where('link_id', '=', $link->id);

            $category->delete();

            $category = new LinkCategory;

            $category->link_id = $link->id;
            $category->category_id = $category_id;

            $category->save();

        }
       }

       if ($request->has('stack'))
       {
        foreach($request->input('stack') as $stack_id)
        {
            $stack = StackLink::where('stack_id', '=', $stack_id)->where('link_id', '=', $link->id);

            $stack->delete();

            $stack = new StackLink;

            $stack->link_id = $link->id;
            $stack->stack_id = $stack_id;

            $stack->save();

        }
       }


        return redirect('/links/' . $id . '/edit')->with('success', 'Link updated');
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

    	$follow = new LinksFollow;

    	$follow->user_id = $user_id;
    	$follow->link_id = $id;

    	$follow->save();

    	return json_encode(array('user_id' => $user_id, 'link_id' => $id));
    }

    public function get_meta_tags(Request $request)
    {
       $url = $request->input('link_url');

       $metaTitle = false;
       $metaDescription  = false;
       $metaImage = false;

       $meta = $this->getUrlData($url);

       $data = array('title' => '', 'description' => '', 'image' => '/images/stack-no-image.jpg');


       if (isset($meta['title']))
       {
        $data['title'] = $meta['title'];
        $metaTitle = true;
       }

       foreach($meta['metaProperties'] as $key => $value)
       {

        $keys = explode(':', $key);

        if (count($keys) == 2)
        {

            if (preg_match('/title/', $key))
            {
                $data['title'] = $value['value'];
            }

            if (preg_match('/description/', $key))
            {
                $data['description'] = $value['value'];
            }

            if (preg_match('/image/', $key))
            {
                $data['image'] = $value['value'];
            }

         }

       }

       return json_encode($data);
    }

    function getUrlData($url, $raw=false) // $raw - enable for raw display
    {
        $result = false;


        $contents = $this->getUrlContents($url);

        $result = array (
                'title' => '',
                'metaTags' => array(),
                'metaProperties' => array(),
            );



        if (isset($contents) && is_string($contents))
        {
            $title = null;
            $metaTags = null;
            $metaProperties = null;

            preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

            if (isset($match) && is_array($match) && count($match) > 0)
            {
                $title = strip_tags($match[1]);
            }

            $pattern = '~<\s*meta\s(?=[^>]*?\b(?:name|property|http-equiv)\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=)))[^>]*?\bcontent\s*=\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))[^>]*>~ix';

            preg_match_all($pattern, $contents, $match);



            if (isset($match) && is_array($match))
            {
                $originals = $match[0];
                $names = $match[1];
                $values = $match[2];

                if (count($originals) == count($names) && count($names) == count($values))
                {
                    $metaTags = array();
                    $metaProperties = $metaTags;
                    if ($raw) {
                        if (version_compare(PHP_VERSION, '5.4.0') == -1)
                             $flags = ENT_COMPAT;
                        else
                             $flags = ENT_COMPAT | ENT_HTML401;
                    }

                    for ($i=0, $limiti=count($names); $i < $limiti; $i++)
                    {
                        if ($match[1][$i] == 'name')
                             $meta_type = 'metaTags';
                        else
                             $meta_type = 'metaProperties';
                        if ($raw)
                            ${$meta_type}[$names[$i]] = array (
                                'html' => htmlentities($originals[$i], $flags, 'UTF-8'),
                                'value' => $values[$i]
                            );
                        else
                            ${$meta_type}[$names[$i]] = array (
                                'html' => $originals[$i],
                                'value' => $values[$i]
                            );
                    }
                }
            }

            $result = array (
                'title' => $title,
                'metaTags' => $metaTags,
                'metaProperties' => $metaProperties,
            );
        }

        return $result;
    }




    function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
    {
        $result = false;

        $contents = @file_get_contents($url);


        // Check if we need to go somewhere else

        if (isset($contents) && is_string($contents))
        {
            preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);

            if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
            {
                if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
                {
                    return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
                }

                $result = false;
            }
            else
            {
                $result = $contents;
            }
        }

        return $contents;
    }

    public function addreminder(Request $request)
    {
        $input = $request->all();

        $link = $request->input('link');
        $day = $request->input('day');
        $unit = $request->input('options');

        switch ((int)$unit)
        {
            case 2: //months

                $date = date("Y-m-d", strtotime(sprintf("+%s months", $day)));

            break;

            case 1: //week

                $date = date("Y-m-d", strtotime(sprintf("+%s weeks", $day)));

            break;

            default:

                $date = date("Y-m-d", strtotime(sprintf("+%s days", $day)));


        }

        $reminder = new Reminder;

        $reminder->user_id = auth()->id();
        $reminder->link = $link;
        $reminder->date = $date;

        $reminder->save();

        return ['Success'];
    }

}
