<?php

namespace App\Http\Controllers;


use Validator;

use Illuminate\Http\Request;

use App\Stack;
use App\StacksFollow;
use App\Category;
use App\user;
use App\Link;
use App\StackLink;
use App\LinkCategory;
use App\Search;
use App\StacksVote;
use DB;
use Auth;

class StacksController extends Controller {


    var $links = array();

    public function __construct() 
    {

       //$this->middleware('auth');

    }

    public function create(Request $request)
    {
        $data['links'] = array();

        $data['user'] = User::find(auth()->id());

        $data['categories'] = Category::all();

        if ($request->old('links'))
        {
            $data['links'] = $request->old('links');
        }


        return view('stacks.create')->with($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
             'title' => 'required',
            ]
        );

        if ($validator->fails())
        {
            return redirect('stacks/create')
                        ->withInput($request->all())
                        ->withErrors($validator);
        }

        $stack = new Stack;

        $stack->title = request('title');

        $stack->content = request('content');

        $stack->user_id = auth()->id();

        $stack->video_id = request('video_id');

        $stack->save();


        if ($request->has('links'))
        {
            $links = $request->input('links');

            foreach($links as $link)
            {
                $x = new Link;

                $x->title = $link['title'];
                $x->link = $link['url'];
                $x->description = $link['description'];
                $x->image = $link['image'];
                $x->user_id = auth()->id();

                $x->save();

                $xy = StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $x->id);

                $xy->delete();

                $xy = new StackLink;

                $xy->link_id = $x->id;
                $xy->stack_id = $stack->id;

                $xy->save();

                $xy = LinkCategory::where('link_id', '=', $x->id)->where('category_id', '=', $link['category']);

                $xy->delete();

                $xy = new LinkCategory;

                $xy->link_id = $x->id;
                $xy->category_id = $link['category'];

                $xy->save();

            }
        }

        return redirect()->home();

    }


    public function follow($id)
    {
        $user_id = auth()->id();

        $stack = StacksFollow::where('user_id', '=', $user_id)
                 ->where('stack_id', '=', $id);

        $stack->delete();

        $follow = new StacksFollow;

        $follow->user_id = $user_id;
        $follow->stack_id = $id;

        $follow->save();

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id, 'action' => 'follow'));
    }

    public function unfollow($id)
    {
        $user_id = auth()->id();

        $stack = StacksFollow::where('user_id', '=', $user_id)
                 ->where('stack_id', '=', $id);

        $stack->delete();

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id, 'action' => 'unfollow'));
    }

    public function dashboard($id)
    {
        $stack = Stack::find($id);

        $categories = array();

        $related = array();

        $links = $stack->links;

        foreach($links as $i => $link)
        {
           $cats = Link::find($link->id)->category->pluck('id')->toArray();

           $categories = array_merge($categories, $cats);

           $url = parse_url($link->link);

           $links[$i]['domain'] = $url['host'];
           $links[$i]['date'] = date("F d, Y", strtotime($link->created_at)); 
           $links[$i]['cats'] = Category::whereIn('id', $cats)->pluck('cat_name')->toArray();

        }

        $categories = Category::whereIn('id', $categories)->get();

        $votes = $stack->votes()->where('vote','=', 1)->get();

        if (Auth::check())
        {    
            $follows = User::find(auth()->id())
                       ->stacksFollow()
                       ->pluck('stack_id')
                       ->toArray();
        }
        else
        {
            $follows = [];
        }               

        $mystack = User::find($stack->user_id)
                   ->stacks()
                   ->get()
                   ->pluck('id')
                   ->toArray();


        $results = User::find($stack->user_id)->stacks()->where('id', '!=', $id)->limit(4)->get();


        foreach($results as $result)
        {
            $follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', $stack->user_id)->get();            

            $related[] = array(
                            'id' => $result->id,
                            'title' => $result->title,
                            'content' => $result->content,
                            'image' => $result->video_id,
                            'follow' => $follow->isEmpty() ? false : true,
                            'updated_at' => date("F d, Y", strtotime($result->updated_at)),                            
                        );
        }    
         


        $data['links'] = $links;

        $data['categories'] = $categories;

        $data['stack'] = $stack;

        $data['follow'] = "";

        $data['related'] = $related;

        $data['upVotes'] = count($votes);

        if (in_array($id, $follows))
        {
            $data['follow'] = sprintf("<a class='follow-button' data-id='%s' data-action='%s'>%s</a>", $id, 'follow', 'UnFollow');
        }
        else if (!in_array($id, $mystack))
        {
            $data['follow'] = sprintf("<a class='follow-button' data-id='%s' data-action='%s'>%s</a>", $id, 'follow', 'Follow');
        }

        return view('stacks.dashboard')->with($data);
    }

    public function explore()
    {
        $tags = User::find(auth()->id())->tags()->get();

        $titleSQL = array();
        $docSQL = array();
        $userSQL = array();
        $categorySQL = array();

        if (!$tags->isEmpty())
        {
            foreach($tags as $tag)
            {
                list($tSQL, $dSQL, $uSQL, $cSQL) = $this->getSearchWeight($tag->tag);

                $titleSQL = array_merge($titleSQL, $tSQL);
                $docSQL = array_merge($docSQL, $cSQL);
                $userSQL = array_merge($userSQL, $uSQL);
                $categorySQL = array_merge($categorySQL, $cSQL);

            }

        }
        else
        {
            $titleSQL[] = 0;
            $docSQL[] = 0;
            $userSQL[] = 0;
            $categorySQL[] = 0;
        }

        $sql = "SELECT s.*, ";

        $sql .= " u.name, u.photo, u.email,";

        $sql .= " GROUP_CONCAT(DISTINCT c2.cat_name SEPARATOR ',') as cat_name, ";

        $sql .= "(
                    (".implode(" + ", $titleSQL)    .") +
                    (".implode(" + ", $docSQL)      .") +
                    (".implode(" + ", $userSQL)     .") +
                    (".implode(" + ", $categorySQL) .")

                ) as relevance";

        $sql .= " FROM stacks s";

        $sql .= " JOIN users u ON u.id = s.user_id";

        $sql .= " JOIN stack_links s2 ON s2.stack_id = s.id";

        $sql .= " LEFT JOIN link_categories c ON c.link_id = s2.link_id";

        $sql .= " LEFT JOIN categories c2 ON c2.id = c.category_id";

        $sql .= " GROUP BY s.id";

        $sql .= " ORDER BY relevance DESC, s2.created_at DESC";

        $results = DB::select($sql);

        $stacks = array();

        $medias = Category::orderBy('cat_name')->get();

        foreach($results as $result)
        {
            $author = array();

            $author = array('name' => $result->name,
                            'email' => $result->email,
                            'photo' => $result->photo);


            $follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();


            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'follow' => $follow->isEmpty() ? false : true,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }

        return view('stacks.explore')->with(['stacks' => $stacks, 'medias' => $medias]);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('search');

        $results = $this->get_results($keywords);

        $medias = Category::orderBy('cat_name')->get();

        $stacks = array();

        foreach($results as $result)
        {
            $author = array();
            $categories = array();


            $author = array('name' => $result->name,
                            'email' => $result->email,
                            'photo' => $result->photo);

            $follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();


            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'follow' => $follow->isEmpty() ? false : true,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }


        return view('stacks.explore')->with(['stacks' => $stacks, 'medias' => $medias]);

    }



    private function filterSearchKeys($query)
    {
        $query = trim(preg_replace("/(\s+)+/", " ", $query));

        $words = array();

        $list = array("in","it","a","the","of","or","I","you","he","me","us","they","she","to","but","that","this","those","then");

        $c = 0;

        foreach(explode(" ", $query) as $key)
        {

            if (in_array($key, $list))
            {
                continue;
            }

            $words[] = $key;

            if ($c >= 15)
            {
                break;
            }

            $c++;
        }
        return $words;
    }


    private function limitChars($query, $limit = 200)
    {
        return substr($query, 0,$limit);
    }


    function getSearchWeight($query)
    {
        $titleSQL = array();

        $userSQL = array();

        $docSQL = array();

        $categorySQL = array();

        $query = trim($query);

        if (mb_strlen($query)===0)
        {
            return false;
        }

        $query = $this->limitChars($query);

        $keywords = $this->filterSearchKeys($query);

        $escQuery = $query;

        $algorithm = Search::first();

        $scoreFullTitle = $algorithm->title;
        $scoreTitleKeyword = $algorithm->title;

        $scoreUsername = $algorithm->author;

        $scoreSummaryKeyword = $algorithm->content;

        $scoreFullDocument = $algorithm->content;
        $scoreDocumentKeyword = $algorithm->content;
        $scoreCategoryKeyword = $algorithm->category;

        if (count($keywords) > 1)
        {
            $titleSQL[] = "if (s.title LIKE '%".$escQuery."%',{$scoreFullTitle},0)";
            $userSQL[] = "if (u.name LIKE '%".$escQuery."%',{$scoreUsername},0)";
            $docSQL[] = "if (s.content LIKE '%".$escQuery."%',{$scoreFullDocument},0)";
        }


        foreach($keywords as $key)
        {
            $titleSQL[] = "if (s.title LIKE '%".$key."%',{$scoreTitleKeyword},0)";
            $userSQL[] = "if (u.name LIKE '%".$key."%',{$scoreUsername},0)";
            $docSQL[] = "if (s.content LIKE '%".$key."%',{$scoreDocumentKeyword},0)";
            //$urlSQL[] = "if (p_url LIKE '%".$key."%',{$scoreUrlKeyword},0)";


            $categorySQL[] = "if ((
                SELECT count(cc.id)
                FROM categories cc
                JOIN link_categories lc ON lc.category_id = cc.id
                JOIN stack_links ls ON ls.link_id = lc.link_id
                WHERE ls.stack_id = s.id
                AND cc.cat_name = '".$key."'
                            ) > 0,{$scoreCategoryKeyword},0)";

        }

        return array($titleSQL, $docSQL, $userSQL, $categorySQL);

    }


    function get_results($query)
    {

        list($titleSQL, $docSQL, $userSQL, $categorySQL) = $this->getSearchWeight($query);

        if (empty($titleSQL))
        {
            $titleSQL[] = 0;
        }

        if (empty($userSQL))
        {
            $userSQL[] = 0;
        }

        if (empty($docSQL))
        {
            $docSQL[] = 0;
        }

        if (empty($urlSQL))
        {
            $urlSQL[] = 0;
        }

        if (empty($tagSQL)){
            $tagSQL[] = 0;
        }

         if (empty($categorySQL)){
            $categorySQL[] = 0;
        }

        $sql = "SELECT s.*, ";

        $sql .= " u.name, u.photo, u.email,";

        $sql .= " GROUP_CONCAT(DISTINCT c2.cat_name SEPARATOR ',') as cat_name, ";

        $sql .= "(
                    (".implode(" + ", $titleSQL)    .") +
                    (".implode(" + ", $docSQL)      .") +
                    (".implode(" + ", $userSQL)     .") +
                    (".implode(" + ", $categorySQL) .")

                ) as relevance";

        $sql .= " FROM stacks s";

        $sql .= " JOIN users u ON u.id = s.user_id";

        $sql .= " JOIN stack_links s2 ON s2.stack_id = s.id";

        $sql .= " LEFT JOIN link_categories c ON c.link_id = s2.link_id";

        $sql .= " LEFT JOIN categories c2 ON c2.id = c.category_id";

        $sql .= " GROUP BY s.id";

        $sql .= " ORDER BY relevance DESC, s2.created_at DESC";

        $results = DB::select($sql);


        if (!$results)
        {
            return false;
        }

        return $results;
    }


    public function view_all()
    {
         $results = User::find(auth()->id())
                    ->stacks()
                    ->orderBy('created_at', 'desc')
                    ->get();

        $stacks = array();


        foreach($results as $stack)
				{
					$author = User::find($stack->user_id);

					$categories = array();

					foreach($stack->links as $link)
					{
						$categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
					}

					$follow = StacksFollow::where('stack_id', '=', $stack->id)->where('user_id', '=', auth()->id())->get();

					$stacks[] = array(
						    'id' => $stack->id,
								'title' => $stack->title,
								'content' => $stack->content,
						    'image' => $stack->video_id,
								'author' => $author,
								'follow' => $follow->isEmpty() ? false : true,
								'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
								'categories' => implode(',', array_unique($categories))
						);
				}


        return view('stacks.view-all', compact('stacks', $stacks));
    }


    public function edit($id)
    {
        $stack = Stack::find($id);

        $data['stack'] = $stack;

        $data['user'] = User::find(auth()->id());

        $data['links'] = $stack->links;

        $data['categories'] = Category::all();

        return view('stacks.edit')->with($data);
    }


    public function update(Request $request, $id)
    {

        $stack = Stack::find($id);

        $stack->title = request('title');

        $stack->content = request('content');

        $stack->subtitle = request('subtitle');

        $stack->user_id = auth()->id();

        $stack->video_id = request('video_id');

        $stack->save();

        $links = StackLink::where('stack_id', '=', $stack->id)->get();

        foreach($links as $link)
        {
            $link_id = $link->link_id;

            Link::find($link_id)->delete();

            StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $link_id)->delete();
        }


        if ($request->has('links'))
        {
            $links = $request->input('links');

            foreach($links as $link)
            {
                $x = new Link;

                $x->title = $link['title'];
                $x->link = $link['url'];
                $x->description = $link['description'];
                $x->image = $link['image'];
                $x->user_id = auth()->id();

                $x->save();

                $xy = StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $x->id);

                $xy->delete();

                $xy = new StackLink;

                $xy->link_id = $x->id;
                $xy->stack_id = $stack->id;

                $xy->save();

                $xy = LinkCategory::where('link_id', '=', $x->id)->where('category_id', '=', $link['category']);

                $xy->delete();

                $xy = new LinkCategory;

                $xy->link_id = $x->id;
                $xy->category_id = $link['category'];

                $xy->save();

            }
        }

        return redirect('stacks/' .  $id . '/edit')->with('success', 'Stack updated');
    }


    public function category($category)
    {

        $medias = Category::orderBy('cat_name')->get();

        $catData = Category::where('id', '=', $category)->first();

        $stacks = array();

        $categorySQL = array();

        $categorySQL[] = "if ((
                SELECT count(cc.id)
                FROM categories cc
                JOIN link_categories lc ON lc.category_id = cc.id
                JOIN stack_links ls ON ls.link_id = lc.link_id
                WHERE ls.stack_id = s.id
                AND cc.cat_name = '".$catData->cat_name."'
                            ) > 0,99,0)";


        $sql = "SELECT s.*, ";

        $sql .= " u.name, u.photo, u.email,";

        $sql .= " GROUP_CONCAT(DISTINCT c2.cat_name SEPARATOR ',') as cat_name, ";

        $sql .= "(
                    (".implode(" + ", $categorySQL) .")

                ) as relevance";

        $sql .= " FROM stacks s";

        $sql .= " JOIN users u ON u.id = s.user_id";

        $sql .= " JOIN stack_links s2 ON s2.stack_id = s.id";

        $sql .= " LEFT JOIN link_categories c ON c.link_id = s2.link_id";

        $sql .= " LEFT JOIN categories c2 ON c2.id = c.category_id";

        $sql .= " GROUP BY s.id";

        $sql .= " ORDER BY relevance DESC, s2.created_at DESC";


        $results = DB::select($sql);


        foreach($results as $result)
        {
            $author = array();

            $author = array('name' => $result->name,
                            'email' => $result->email,
                            'photo' => $result->photo);


            $follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'follow' => $follow->isEmpty() ? false : true,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }

        return view('stacks.explore')->with(['stacks' => $stacks, 'medias' => $medias]);
    }

    public function vote(Request $request, $id)
    {
        $vote = 1;

        $action = $request->input('vote');

        StacksVote::where('stack_id', '=', $id)->where('user_id', '=', auth()->id())->delete();

        
        $stack = new StacksVote;

        $stack->user_id = auth()->id();
        $stack->stack_id = $id;
        $stack->vote = $action;

        $stack->save();



        $stack = Stack::find($id);


        $vote = $stack->votes()->where('vote','=', 1)->get();


        return json_encode(array('stack_id' => $id, 'vote' => count($vote)));
    }

}
