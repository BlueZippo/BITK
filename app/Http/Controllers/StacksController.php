<?php

namespace App\Http\Controllers;


use Validator;

use Illuminate\Http\Request;

use App\Stack;
use App\StacksFollow;
use App\StacksHidden;
use App\StacksFavorite;
use App\Category;
use App\User;
use App\Link;
use App\StackLink;
use App\LinkCategory;
use App\Search;
use App\StacksVote;
use App\StackComments;
use App\LinkComment;
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

        $data['media_id'] = MediaType::first()->id;

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
        $data['downvote'] = 0;

        $medias = MediaType::orderby('media_type')->get();

        $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

        $options = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                    );

        $data['medias'] = $medias;
        $data['recents'] = $recents;
        $data['options'] = $options;

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

        if (request('id'))
        {
            $stack = Stack::find(request('id'));
        }
        else
        {
            $stack = new Stack;
        }



        $stack->title = strip_tags(request('title'));

        $stack->content = strip_tags(request('content'));

        $stack->user_id = auth()->id();

        $stack->video_id = request('video_id');

        $stack->status_id = request('status_id');

        $stack->private = request('private');

        $stack->media_type = request('media_type');

        $stack->save();

        DB::table('stack_categories')->where('stack_id','=', $stack->id)->delete();
        DB::table('links')->where('stack_id', '=', $stack->id)->delete();

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

                if (empty($link['code']))
                {    
                    $x->code =  $x->convertIntToShortCode();
                }    
                else
                {
                    $x->code = $link['code'];
                }  


                $x->save();



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

    public function like($id)
    {
        $user_id = auth()->id();

        $stack = StacksFavorite::where('user_id', '=', $user_id)
                 ->where('stack_id', '=', $id);

        $stack->delete();

        $favorite = new StacksFavorite;

        $favorite->user_id = $user_id;
        $favorite->stack_id = $id;

        $favorite->save();

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id, 'action' => 'like'));
    }

    public function unlike($id)
    {
        $user_id = auth()->id();

        $stack = StacksFavorite::where('user_id', '=', $user_id)
                 ->where('stack_id', '=', $id);

        $stack->delete();

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id, 'action' => 'unlike'));
    }


    public function hide($id)
    {
        $user_id = auth()->id();

        $stack = new StacksHidden;

        $stack->user_id = $user_id;
        $stack->stack_id = $id;

        $stack->save();

        return json_encode(array('user_id' => $user_id, 'stack_id' => $id));
    }

    public function preview($id)
    {
        return $this->dashboard($id, 'preview');
    }

    public function dashboard($id, $mode = 'normal')
    {
        $stack = Stack::find($id);

        $view = $stack->view;

        $stack->view = $view + 1;

        $stack->save();

        $medias = array();

        $related = array();

        $comments = StackComments::where('stack_id', '=', $id)->get();

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

            $linkComments = LinkComment::where('link_id', '=', $link->id)->get();

            if (strlen($link->code) > 0)
            {    
                $links[$i]['link'] = config('APP_URL') . '/x/' . $link->code;
            }    

            $links[$i]['domain'] = isset($url['host']) ? $url['host'] : "";
            $links[$i]['media_type'] = $media_type;
            $links[$i]['date'] = date("F d, Y", strtotime($link->created_at));
            $links[$i]['comments'] = count($linkComments);


        }

        $medias = MediaType::whereIn('id', $medias)->orderby('media_type')->get();

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

        $data['comments'] = count($comments);

        if (in_array($id, $follows))
        {
            $data['follow'] = sprintf("<a class='follow-button' data-id='%s' data-action='%s'>%s</a>", $id, 'follow', 'UnFollow');
        }
        else if (!in_array($id, $mystack))
        {
            $data['follow'] = sprintf("<a class='follow-button' data-id='%s' data-action='%s'>%s</a>", $id, 'follow', 'Follow');
        }


        $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

        $data['options'] = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                    );


        if ($mode == 'preview')
        {
            return view('stacks.preview')->with($data);
        }   
        else
        {
            return view('stacks.dashboard')->with($data);
        }    
    }

    public function explore($sort = 'popular')
    {
        $tags = User::find(auth()->id())->tags()->get();

        $titleSQL = array();
        $docSQL = array();
        $userSQL = array();
        $categorySQL = array();

        $hidden = StacksHidden::where('user_id', '=', auth()->id())->get()->pluck('stack_id')->toArray();

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

        $sql .= " GROUP_CONCAT(DISTINCT c2.cat_name SEPARATOR ',') as cat_name";

        if ($sort)
        {
            $sql .= ", count(f.stack_id) as follows";
            $sql .= ", count(v.stack_id) as votes";
            $sql .= ", count(co.stack_id) as comments";

            $sql .= ", count(f.stack_id) + count(v.stack_id) + s.view as popular";
        }
        else
        {
            $sql .= ", (
                        (".implode(" + ", $titleSQL)    .") +
                        (".implode(" + ", $docSQL)      .") +
                        (".implode(" + ", $userSQL)     .") +
                        (".implode(" + ", $categorySQL) .")

                    ) as relevance";
        }

        $sql .= " FROM stacks s";

        $sql .= " JOIN users u ON u.id = s.user_id";

        $sql .= " LEFT JOIN stack_links s2 ON s2.stack_id = s.id";

        $sql .= " LEFT JOIN stack_categories c ON c.stack_id = s.id";

        $sql .= " LEFT JOIN categories c2 ON c2.id = c.category_id";

        $sql .= " LEFT JOIN stacks_follows f ON f.stack_id = s.id";

        $sql .= " LEFT JOIN stacks_votes v ON v.stack_id = s.id AND v.vote = 1";

        $sql .= " LEFT JOIN stack_comments co ON co.stack_id = s.id";

        $sql .= " WHERE s.status_id = 1 AND s.private = 0";

        if ($hidden)
        {
            $sql .= " AND s.id NOT IN (".implode(',', $hidden).")";
        }

        $sql .= " GROUP BY s.id";

        if ($sort)
        {
            switch ($sort)
            {
                case 'popular':

                    $sql .= " ORDER BY popular DESC, s2.created_at DESC";

                break;

                case 'top-voted':

                     $sql .= " ORDER BY votes DESC, s2.created_at DESC";

                break;

                case 'trending':

                    $sql .= " ORDER BY comments DESC, s2.created_at DESC";

                break;

                default:

                    $sql .= " ORDER BY s.created_at DESC";

            }
        }
        else
        {
            $sql .= " ORDER BY relevance DESC, s.created_at DESC";
        }

        //echo $sql;

        $navSort = array(

                'Stacks' => array('popular' => 'Popular',
                                  'new' => 'New',
                                  'trending' => 'Trending',
                                  'top-voted' => 'Top Voted',
                                  'top-thread' => 'Top Threads',
                                  'following' => 'Following',
                                  'my' => 'My Stacks'),

                'People' => array('new-people' => 'New',
                                  'trending-people' => 'Trending',
                                  'top-people' => 'Top Followed',
                                  'following-people' => 'Following',
                                  'my-profile' => 'My Profile')

            );


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

            $favorite = StacksFavorite::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

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
                              'favorite' => $favorite->isEmpty() ? false : true,
                              'media_type' => $result->media_type,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }


        $friends = User::where('id', '!=', auth()->id())->limit(5)->orderby('name')->get();

        $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

        $options = array(
                    'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                    'parking' => 'Parking Lot',
                    'new' => 'Create New Stack',
                    'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                    );

        return view('stacks.explore')->with(['stacks' => $stacks,
                                             'medias' => $medias,
                                             'navSort' => $navSort,
                                             'sort' => $sort,
                                             'options' => $options,
                                             'friends' => $friends
                                            ]);
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

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',1)->get();

            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=',0)->get();

            $favorite = StacksFavorite::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

            $comments = StackComments::where('stack_id', '=', $result->id)->get();

            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'upvotes' => $this->number_format(count($upvotes)),
                              'downvotes' => $this->number_format(count($downvotes)),
                              'comments' => $this->number_format(count($comments)),
                              'follow' => $follow->isEmpty() ? false : true,
                              'favorite' => $favorite->isEmpty() ? false : true,
                              'media_type' => $result->media_type,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }

        $navSort = array(

                'Stacks' => array('popular' => 'Popular',
                                  'new' => 'New',
                                  'trending' => 'Trending',
                                  'top-voted' => 'Top Voted',
                                  'top-thread' => 'Top Threads',
                                  'following' => 'Following',
                                  'my' => 'My Stacks'),

                'People' => array('new-people' => 'New',
                                  'trending-people' => 'Trending',
                                  'top-people' => 'Top Followed',
                                  'following-people' => 'Following',
                                  'my-profile' => 'My Profile')

            );

        $friends = User::where('id', '!=', auth()->id())->limit(5)->orderby('name')->get();


        return view('stacks.explore')->with(['stacks' => $stacks,
                                             'medias' => $medias,
                                             'navSort' => $navSort,
                                             'sort' => 'popular',
                                             'friends' => $friends]);

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

            $downvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=',0)->get();;

            $upvotes = StacksVote::where('stack_id', '=', $stack->id)->where('vote', '=',1)->get();;

            $comments = StackComments::where('stack_id', '=', $stack->id)->get();

			$stacks[] = array(
				    'id' => $stack->id,
						'title' => $stack->title,
						'content' => $stack->content,
				    'image' => $stack->video_id,
						'author' => $author,
						'follow' => $follow->isEmpty() ? false : true,
                        'upvotes' => count($upvotes),
                        'downvotes' => count($downvotes),
                        'comments' => count($comments),
						'updated_at' => date("F d, Y", strtotime($stack->updated_at)),
						'categories' => implode(',', array_unique($categories))
				);
		}


        return view('stacks.view-all', compact('stacks', $stacks));
    }


    public function edit($id, $media_id = 0)
    {
        $stack = Stack::find($id);

        if ($media_id == 0)
        {
            $media_id = MediaType::orderby('media_type')->first()->id;
        }

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

            $upvote = StacksVote::where('stack_id', '=', $id)->where('vote','=',1)->get();
            $downvote = StacksVote::where('stack_id', '=', $id)->where('vote','=', 0)->get();

            $data['upvote'] = count($upvote);
            $data['downvote'] = count($downvote);

            $data['stack_categories'] = $categories ? implode(', ', $categories) : 'enter a topic...';
            $data['stack_category_ids'] = $category_ids;

            $data['last_updated'] = date("M d, Y", strtotime($stack->updated_at));

            $data['medias'] = MediaType::orderby('media_type')->get();

            $data['media_id'] = $media_id;

            $data['active_media_id'] = $media_id;

            $recents = Stack::select('id', 'title')->where('user_id', '=', auth()->id())->orderby('updated_at', 'desc')->limit(5)->get();

            $options = array(
                        'Most Recent Stacks' => $recents->pluck('title', 'id')->toArray(),
                        'parking' => 'Parking Lot',
                        'new' => 'Create New Stack',
                        'My Stacks' => Stack::where('user_id', '=', auth()->id())->orderby('title')->get()->pluck('title','id')->toArray(),
                        );


        $data['recents'] = $recents;
        $data['options'] = $options;

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

        $stack->media_type = request('media_type');

        $stack->status_id = request('status_id');

        $stack->private = request('private');

        $stack->save();

        $active_media_id = request('active_media_id');

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

                if (empty($link['code']))
                {    
                    $x->code =  $x->convertIntToShortCode();
                }    
                else
                {
                    $x->code = $link['code'];
                }

     

                $x->save();

            }
        }

        return redirect('stacks/' .  $id . '/edit/' . $active_media_id)->with('success', 'Stack updated');
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

    public function popular()
    {
        return $this->explore('popular');
    }

    public function new()
    {
       return $this->explore('new');
    }

    public function trending()
    {
        return $this->explore('trending');
    }

    public function top()
    {
        return $this->explore('top-voted');
    }

    public function thread()
    {
        return $this->explore('top-thread');
    }

    public function following()
    {
        return $this->explore('following');
    }

    public function my()
    {
        return $this->explore('my');
    }

    public function myprofile()
    {
        return $this->explore('my-profile');
    }

    public function people_following()
    {
        return $this->explore('following-people');
    }

    public function people_top()
    {
        return $this->explore('top-people');
    }

    public function people_trending()
    {
        return $this->explore('trending-people');
    }

    public function people()
    {
        return $this->explore('new-people');
    }


    public function upload(Request $request)
    {
        $this->validate($request, [

            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $image = $request->file('upload');

        $user_id = auth()->id();

        $photo = sprintf("stacks-%s-%s.%s", $user_id, time(), $image->getClientOriginalExtension());

        $destinationPath = public_path('/upload');

        $image->move($destinationPath, $photo);

        return json_encode(array('message'=> 'Image uploaded successfully', 'photo' => '/upload/' . $photo));
    }

    public function autosave(Request $request)
    {
        if (request('id'))
        {
            $id = request('id');

            $stack = Stack::find($id);

            $stack->title = request('title');

            $stack->content = request('content');

            $stack->subtitle = request('subtitle');

            $stack->user_id = auth()->id();

            $stack->video_id = request('video_id');

            $stack->media_type = request('media_type');

            $stack->status_id = request('status_id');

            $stack->private = request('private');

            $stack->save();


        }
        else
        {
            $stack = new Stack;

            $stack->title = request('title');

            $stack->content = request('content');

            $stack->subtitle = request('subtitle');

            $stack->user_id = auth()->id();

            $stack->video_id = request('video_id');

            $stack->media_type = request('media_type');

            $stack->status_id = request('status_id');

            $stack->private = request('private');

            $stack->save();

            $id = $stack->id;
        }


        DB::table('stack_categories')->where('stack_id','=', $id)->delete();
        DB::table('links')->where('stack_id', '=', $id)->delete();

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
                $x->id  = $link['id'];
                $x->link = $link['url'];
                $x->description = $link['description'];
                $x->image = $link['image'];
                $x->media_id = $link['media_id'];
                $x->stack_id = $stack->id;
                $x->user_id = auth()->id();

                if (empty($link['code']))
                {    
                    $x->code =  $x->convertIntToShortCode();
                }    
                else
                {
                    $x->code = $link['code'];
                }   

                $x->save();

            }
        }

        return json_encode(array('id' => $id));
    }

    public function more($page)
    {
        $limit = 6;
        $more = 1;
        $offset = ($limit * ($page - 1)) + 4;


        $results = Stack::where('user_id', '=', auth()->id())
                    ->offset($offset)
                    ->limit($limit)
                    ->orderby('created_at', 'desc')
                    ->get();

        $mystacks = array();

        foreach($results as $result)
        {
            $author = User::find($result->user_id);

            $categories = array();

            foreach($result->links as $link)
            {
                $categories = array_merge($categories, $link->category->pluck('cat_name')->toArray());
            }

            $follow = StacksFollow::where('stack_id', '=', $result->id)->where('user_id', '=', auth()->id())->get();

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 1)->get();

            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 0)->get();

            $mystacks[] = array(
                    'id' => $result->id,
                    'title' => $result->title,
                    'content' => $result->content,
                    'image' => $result->video_id,
                    'author' => $author,
                    'upvotes' => $this->number_format(count($upvotes)),
                    'downvotes' => $this->number_format(count($downvotes)),
                    'user_id' => $result->user_id,
                    'follow' => $follow->isEmpty() ? false : true,
                    'media_type' => $result->media_type,
                    'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                    'categories' => implode(',', array_unique($categories))
                );
        }

        if (count($mystacks) < $limit)
        {
            $more = 0;
        }


        $data['mystacks'] = $mystacks;

        $json['more'] = $more;

        $json['html'] = view('stacks.mystacks-more')->with($data)->render();

        return json_encode($json);
    }

    public function trash(Request $request)
    {
        $id = request('id');

        $stack = Stack::find($id);

        if ($stack->user_id == auth()->id())
        {

            StacksFollow::where('stack_id', '=', $id)->delete();

            Link::where('stack_id', '=', $id)->delete();

            StacksFavorite::where('stack_id', '=', $id)->delete();

            StacksHidden::where('stack_id', '=', $id)->delete();

            StacksVote::where('stack_id', '=', $id)->delete();

            StackCategory::where('stack_id', '=', $id)->delete();

            StackComments::where('stack_id', '=', $id)->delete();

            $stack->delete();
        }

        return ['id' => $id];
    }

    public function clone($id)
    {
        $stack = Stack::find($id);

        if ($stack->user_id == auth()->id())
        {

            $new = new Stack;

            $new->title = sprintf("%s (cloned)", $stack->title);

            $new->content = $stack->content;

            $new->user_id = auth()->id();

            $new->video_id = $stack->video_id;

            $new->media_type = $stack->media_type;

            $new->status_id = 0;

            $new->private = 0;

            $new->save();


            foreach($stack->categories as $category)
            {
                $x = new StackCategory;

                $x->stack_id = $new->id;
                $x->category_id = $category->category_id;

                $x->save();
            }

            foreach($stack->links as $link)
            {
                $x = new Link;

                $x->title = $link->title;
                $x->link = $link->link;
                $x->description = $link->description;
                $x->image = $link->image;
                $x->media_id = $link->media_id;
                $x->stack_id = $new->id;
                $x->user_id = auth()->id();

                $x->save();

            }

            return ['id' => $new->id, 'success' => true];

        }
        else
        {
            return ['success' => false];
        }


    }

}
