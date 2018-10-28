<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Link;
use App\Stack;
use App\LinksFollow;
use App\StacksFollow;
use App\Category;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;

class PublicController extends Controller {

	public function __construct()
	{
	
	}

    public function index() {

        

        $titleSQL = array();
        $docSQL = array();
        $userSQL = array();
        $categorySQL = array();

        $titleSQL[] = 0;
        $docSQL[] = 0;
        $userSQL[] = 0;
        $categorySQL[] = 0;

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


            
            $stacks[] = array('title' => $result->title,
                              'image' => $result->video_id,
                              'author' => $author,
                              'id' => $result->id,
                              'follow' => false,
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




}