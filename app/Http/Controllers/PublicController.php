<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\Stack;
use App\LinksFollow;
use App\StacksFollow;
use App\Category;
use App\StacksVote;
use App\StackComments;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;

class PublicController extends Controller {

	public function __construct()
	{
	
	}

    public function index($sort = false) {

        

        $titleSQL = array();
        $docSQL = array();
        $userSQL = array();
        $categorySQL = array();

        $titleSQL[] = 0;
        $docSQL[] = 0;
        $userSQL[] = 0;
        $categorySQL[] = 0;


        $navSort = array(

                'Stacks' => array('popular' => 'Popular', 
                                  'new' => 'New', 
                                  'trending' => 'Trending',
                                  'top-voted' => 'Top Voted',
                                  'top-thread' => 'Top Threads',
                                  'following' => 'Following'
                              ),

                'People' => array('new-people' => 'New', 
                                  'trending-people' => 'Trending',
                                  'top-people' => 'Top Followed',
                                  'following-people' => 'Following'
                              )

            );

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

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 1)->get();
            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 0)->get();
            $comments = StackComments::where('stack_id', '=', $result->id)->get();

            
            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'upvotes' => count($upvotes),
                              'downvotes' => count($downvotes),
                              'comments' => count($comments),
                              'follow' => false,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }

        return view('stacks.explore')->with(['stacks' => $stacks, 'medias' => $medias, 'navSort' => $navSort, 'sort' => $sort]);
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

            $upvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 1)->get();
            $downvotes = StacksVote::where('stack_id', '=', $result->id)->where('vote', '=', 0)->get();


            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'upvotes' => count($upvotes),
                              'downvotes' => count($downvotes),

                              'follow' => $follow->isEmpty() ? false : true,
                              'updated_at' => date("F d, Y", strtotime($result->updated_at)),
                              'categories' => $result->cat_name
                          );
        }


        return view('stacks.explore')->with(['stacks' => $stacks, 'medias' => $medias]);

    }


    public function popular()
    {
        return $this->index('popular');
    }

    public function new()
    {
       return $this->index('new');
    }

    public function trending()
    {
        return $this->index('trending');
    }

    public function top()
    {
        return $this->index('top-voted');
    }

    public function thread()
    {
        return $this->index('top-thread');
    }

    public function following()
    {
        return $this->index('following');
    }

    public function my()
    {
        return $this->index('my');
    }

    public function myprofile()
    {
        return $this->index('my-profile');
    }

    public function people_following()
    {
        return $this->index('following-people');
    }

    public function people_top()
    {
        return $this->index('top-people');
    }

    public function people_trending()
    {
        return $this->index('trending-people');
    }

    public function people()
    {
        return $this->index('new-people');
    }


}
