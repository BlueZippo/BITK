<?php

namespace App\Http\Controllers;


use Validator;

use Illuminate\Http\Request;

use App\Stack;
use App\StacksFollow;
use App\Category;
use App\User;
use App\Link;
use App\StackLink;
use App\LinkCategory;
use App\Search;
use App\StacksVote;
use App\StackComments;
use App\MediaType;
use App\StackCategory;
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

        $data['medias'] = MediaType::all();

        $data['categories'] = Category::all();

        $data['stack_category_ids'] = array();

        if ($request->old('links'))
        {
            $data['links'] = $request->old('links');
        }

        $data['last_updated'] = date("M d, Y");
        $data['upvote'] = 0;


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

        $stack->title = strip_tags(request('title'));

        $stack->content = strip_tags(request('content'));

        $stack->user_id = auth()->id();

        $stack->video_id = request('video_id');

        $stack->status_id = request('status_id');

        $stack->save();

        if ($request->has('categories'))
        {
            $categories = $request->input('categories');

            foreach($categories as $category_id)
            {
                $x = new StackCategory;

                $x->stack_id = $stack->id;
                $x->category_id = $category_id;

                $x->save();
            }
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
                $x->media_id = $link['media_id'];
                $x->stack_id = $stack->id;
                $x->user_id = auth()->id();

                $x->save();

                /*
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

                */

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

        $medias = array();

        $related = array();

        $links = $stack->links;

        foreach($links as $i => $link)
        {
            $media_type = "";

            $medias[] = $link->media_id;

            if ($link->media_id > 0)
            {
                $media_type = $link->media->media_type;                
            }    

            $url = parse_url($link->link);

            $links[$i]['domain'] = $url['host'];
            $links[$i]['media_type'] = $media_type;
            $links[$i]['date'] = date("F d, Y", strtotime($link->created_at)); 
           

        }

        $medias = MediaType::whereIn('id', $medias)->get();

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


        $results = User::find($stack->user_id)
                    ->stacks()
                    ->where('status_id', '=', 1)
                    ->where('id', '!=', $id)
                    ->limit(4)->get();


        foreach($results as $result)
        {
            $follow = StacksFollow::where('stack_id', '=', $result->id)
                                  ->where('user_id', '=', $stack->user_id)                                 
                                  ->get();            

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

        $data['medias'] = $medias;

        $data['stack'] = $stack;

        $data['follow'] = "";

        $data['related'] = $related;

        $data['upvote'] = count($votes);

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

        $sql .= " LEFT JOIN stack_categories c ON c.stack_id = s.id";

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

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',1)->get();

            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',0)->get();;

            $comments = StackComments::where('stack_id', '=', $result->id)->get();

            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'upvotes' => $this->number_format(count($upvotes)),
                              'downvotes' => $this->number_format(count($downvotes)),
                              'comments' => $this->number_format(count($comments)),
                              'follow' => $follow->isEmpty() ? false : true,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }

        return view('stacks.explore')->with(['stacks' => $stacks, 'medias' => $medias]);
    }


    function number_format($num)
    {
        if($num > 1000) 
        {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;

        }

        return $num;
    
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

        $sql .= " LEFT JOIN stack_categories c ON c.stack_id = s.id";

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

        if (auth()->id() == $stack->user_id)
        {        

            $data['stack'] = $stack;

            $data['user'] = User::find($stack->user_id);

            $data['links'] = $stack->links;

            $data['categories'] = Category::all();

            $categories = array();
            $category_ids = array();

            foreach($stack->categories as $category)
            {
                $categories[] = $category->category->cat_name;
                $category_ids[] = $category->category_id;
            }    

            $upvote = StacksVote::where('stack_id', '=', $id)->get();

            $data['upvote'] = count($upvote);

            $data['stack_categories'] = $categories ? implode(', ', $categories) : 'enter a topic...';
            $data['stack_category_ids'] = $category_ids;

            $data['last_updated'] = date("M d, Y", strtotime($stack->updated_at));

            $data['medias'] = MediaType::all();

            return view('stacks.edit')->with($data);

        }
        else
        {
            return redirect('/stacks/' . $id . '/dashboard');
        }    
    }


    public function update(Request $request, $id)
    {

        $stack = Stack::find($id);

        $stack->title = request('title');

        $stack->content = request('content');

        $stack->subtitle = request('subtitle');

        $stack->user_id = auth()->id();

        $stack->video_id = request('video_id');

        $stack->status_id = request('status_id');

        $stack->save();

        DB::table('stack_categories')->where('stack_id','=', $id)->delete();


        if ($request->has('categories'))
        {
            $categories = $request->input('categories');

            foreach($categories as $category_id)
            {
                $x = new StackCategory;

                $x->stack_id = $stack->id;
                $x->category_id = $category_id;

                $x->save();
            }
        }    

        $links = Link::where('stack_id', '=', $id)->get();

        foreach($links as $link)
        {
            $link_id = $link->id;

            Link::find($link_id)->delete();

            //StackLink::where('stack_id', '=', $stack->id)->where('link_id', '=', $link_id)->delete();
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
                $x->media_id = $link['media_id'];
                $x->stack_id = $id;
                $x->user_id = auth()->id();

                $x->save();

                /*
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
                */

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
                JOIN stack_categories lc ON lc.category_id = cc.id
                WHERE lc.stack_id = s.id
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

        $sql .= " LEFT JOIN stack_categories c ON c.stack_id = s.id";

        $sql .= " LEFT JOIN categories c2 ON c2.id = c.category_id";

        $sql .= " GROUP BY s.id";

        $sql .= " ORDER BY relevance DESC, c.created_at DESC";


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

        $downvote = $stack->votes()->where('vote', '=', 0)->get();

        return json_encode(array('stack_id' => $id, 'upvote' => count($vote), 'downvote' => count($downvote)));
    }


    function comments($id)
    {
        $json = array();

        $stack = Stack::find($id);

        $data['stack_id'] = $id;
        $data['stack'] = $stack;

        $comments = $stack->comments()->limit(5)->orderby('updated_at', 'desc')->get();

        $data['comments'] = $comments;
        $data['page'] = 1;

        $html = view('stacks.comments')->with($data);

        $json['html'] = (string)$html;

        return ['html' => (string)$html];
    }

}
