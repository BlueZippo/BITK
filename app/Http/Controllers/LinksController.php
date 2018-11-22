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
use App\LinkParser;
use App\phpQuery\phpQuery;
use App\MediaType;
use DB;
use Config;

class LinksController extends Controller
{

    
    protected static $table = "short_urls";
    protected static $checkUrlExists = true;

    protected $pdo;
    protected $timestamp;


    public function __construct() {

        $this->middleware('auth');

         $this->timestamp = $_SERVER["REQUEST_TIME"];

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

       $stack_id = $request->input('stack_id');

       if ($stack_id == 'parking')
       {
            $stack_id = 0;
       }
       else if ($stack_id == 'new')
       {
        $stack = new Stack;

        $stack->title = 'enter title...';
        $stack->content = 'enter a topic...';
        $stack->user_id = auth()->id();

        $stack->save();

        $stack_id  = $stack->id;

       }

       $link = new Link;

       $link->title = $request->input('link_title');
       $link->description = $request->input('link_description');
       $link->link = $request->input('link_url');
       $link->stack_id = (int)$stack_id;
       $link->media_id = $request->input('media_id');
       $link->image = $request->input('link_image');

       $link->code = $link->convertIntToShortCode();

       $link->user_id = auth()->id();

       $link->save();

       if ($stack_id)
       {
             return ['message' => "Success", 'redirect' => '/stacks/' . $stack_id . '/edit/' . $link->media_id];
       }
       else
       {

            $html = view('links.link')->with(['link' => $link])->render();

            return ['message' => "Success", 'html' => $html];
        }

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

       $uri = parse_url($url);
       
       $metaTitle = false;
       $metaDescription  = false;
       $metaImage = false;

       switch ($uri['host'])
       {
        case 'www.amazon.com':

            $data = $this->get_amazon_data($url);

        break;

        default:   

           if ($uri && isset($uri['host']))
           {
            $parser = LinkParser::where('domain', '=', $uri['host'])->first();
           }
    

           if ($parser)
           {

            $content = $this->get_remote_data($url, $parser);
           }
           else
           { 

               $meta = $this->getUrlData($url);

               $data = array('title' => '', 'description' => '', 'image' => '/images/stack-placeholder.png');


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

        //$contents = $this->get_remote_data($url);

        //echo $contents;

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


    function xxget_remote_data($url, $parser)
    {
        $html  = phpQuery::newDocumentFileHTML($url); 

        $content = array();

        echo $parser->image;

        $image = phpQuery::pq($parser->image, $html);


        print_r($image);


        return $content;
    }


    function get_remote_data($url, $post_paramtrs=false,$extra=array('schemeless'=>true, 'replace_src'=>true, 'return_array'=>false))   
    {
        $c = curl_init();

        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        
        if($post_paramtrs)
        { 
            curl_setopt($c, CURLOPT_POST,TRUE);  
            curl_setopt($c, CURLOPT_POSTFIELDS, (is_array($post_paramtrs)? http_build_query($post_paramtrs) : $post_paramtrs) ); 
        }
    
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
        
        $headers[]= "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:76.0) Gecko/20100101 Firefox/76.0";     
        $headers[]= "Pragma: ";  
        $headers[]= "Cache-Control: max-age=0";
        
        if (!empty($post_paramtrs) && !is_array($post_paramtrs) && is_object(json_decode($post_paramtrs)))
        { 
            $headers[]= 'Content-Type: application/json'; 
            $headers[]= 'Content-Length: '.strlen($post_paramtrs); 
        }
    
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_MAXREDIRS, 10);
    
        $follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;  

        if ($follow_allowed)
        {
            curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
        }
    
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($c, CURLOPT_REFERER, $url);
        curl_setopt($c, CURLOPT_TIMEOUT, 60);
        curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($c, CURLOPT_HEADER, !empty($extra['return_array']));
        
        $data = curl_exec($c);

        if(!empty($extra['return_array'])) 
        {
            preg_match("/(.*?)\r\n\r\n((?!HTTP\/\d\.\d).*)/si",$data, $x); 
            preg_match_all('/(.*?): (.*?)\r\n/i', trim('head_line: '.$x[1]), $headers_, PREG_SET_ORDER); 

            foreach($headers_ as $each)
            { 
                $header[$each[1]] = $each[2]; 
            }   

            $data=trim($x[2]);
        }


        $status=curl_getinfo($c); 
        curl_close($c);
    
        if($status['http_code']==301 || $status['http_code']==302) 
        {
            if (!$follow_allowed)
            {
                if(empty($redirURL))
                {
                    if(!empty($status['redirect_url']))
                    {
                        $redirURL=$status['redirect_url'];
                    }
                }
            
                if(empty($redirURL))
                {
                    preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);                 

                    if (!empty($m[2]))
                    { 
                        $redirURL=$m[2]; 
                    } 
                }
            
                if(empty($redirURL))
                {
                    preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m); 
                    
                    if (!empty($m[1]))
                    { 
                        $redirURL=$m[1]; 
                    } 
                }
                
                if(!empty($redirURL))
                {
                    $t=debug_backtrace(); 
                    return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);
                }
            }
        }
        elseif ( $status['http_code'] != 200 ) 
        { 
            $data =  "ERRORCODE22 with $url<br/><br/>Last status codes:".json_encode($status)."<br/><br/>Last data got:$data";
        }

        if(function_exists('url_corrections_for_content_HELPER'))
        {      
            $data= url_corrections_for_content_HELPER($data, $status['url'],   array('schemeless'=>!empty($extra['schemeless']), 'replace_src'=>!empty($extra['replace_src']), 'rawgit_replace'=>!empty($extra['rawgit_replace']) )  );     
        }
        
        $answer = ( !empty($extra['return_array']) ? array('data'=>$data, 'header'=>$header, 'info'=>$status) : $data);
        

        return $answer;      

    }     


    function url_corrections_for_content_HELPER( $content=false, $url=false,     $extra_opts=array('schemeless'=>false, 'replace_src'=>false, 'rawgit_replace'=>false) ) 
    {
        $GLOBALS['rdgr']['schemeless'] =$extra_opts['schemeless'];
        $GLOBALS['rdgr']['replace_src']=$extra_opts['replace_src'];
        $GLOBALS['rdgr']['rawgit_replace']=$extra_opts['rawgit_replace'];
    
        if($GLOBALS['rdgr']['schemeless'] || $GLOBALS['rdgr']['replace_src'] ) 
        {
            if($url) 
            {
                $GLOBALS['rdgr']['parsed_url']          = parse_url($url);
                $GLOBALS['rdgr']['urlparts']['domain_X']= $GLOBALS['rdgr']['parsed_url']['scheme'].'://'.$GLOBALS['rdgr']['parsed_url']['host'];
                $GLOBALS['rdgr']['urlparts']['path_X']  = stripslashes(dirname($GLOBALS['rdgr']['parsed_url']['path']).'/');
                $GLOBALS['rdgr']['all_protocols']= array('adc','afp','amqp','bacnet','bittorrent','bootp','camel','dict','dns','dsnp','dhcp','ed2k','empp','finger','ftp','gnutella','gopher','http','https','imap','irc','isup','javascript','ldap','mime','msnp','map','modbus','mosh','mqtt','nntp','ntp','ntcip','openadr','pop3','radius','rdp','rlogin','rsync','rtp','rtsp','ssh','sisnapi','sip','smtp','snmp','soap','smb','ssdp','stun','tup','telnet','tcap','tftp','upnp','webdav','xmpp');
            }
        
            $GLOBALS['rdgr']['ext_array']   = array(
                'src'   => array('audio','embed','iframe','img','input','script','source','track','video'),
                'srcset'=> array('source'),
                'data'  => array('object'),
                'href'  => array('link','area','a'),
                'action'=> array('form')
                //'param', 'applet' and 'base' tags are exclusion, because of a bit complex structure
            );
        
            $content= preg_replace_callback(
                        '/<(((?!<).)*?)>/si',   //avoids unclosed & closing tags
                        function($matches_A){
                            $content_A = $matches_A[0];
                            $tagname = preg_match('/((.*?)(\s|$))/si', $matches_A[1], $n) ? $n[2] : "";
                            foreach($GLOBALS['rdgr']['ext_array'] as $key=>$value){
                                if(in_array($tagname,$value)){
                                    preg_match('/ '.$key.'=(\'|\")/i', $content_A, $n);
                                    if(!empty($n[1])){
                                        $GLOBALS['rdgr']['aphostrope_type']= $n[1];
                                        $content_A = preg_replace_callback(
                                            '/( '.$key.'='.$GLOBALS['rdgr']['aphostrope_type'].')(.*?)('.$GLOBALS['rdgr']['aphostrope_type'].')/i',
                                            function($matches_B){
                                                $full_link = $matches_B[2];
                                                //correction to files/urls
                                                if(!empty($GLOBALS['rdgr']['replace_src'])  ){
                                                    //if not schemeless url
                                                    if(substr($full_link, 0,2) != '//'){
                                                        $replace_src_allow=true;
                                                        //check if the link is a type of any special protocol
                                                        foreach($GLOBALS['rdgr']['all_protocols'] as $each_protocol){
                                                            //if protocol found - dont continue
                                                            if(substr($full_link, 0, strlen($each_protocol)+1) == $each_protocol.':'){
                                                                $replace_src_allow=false; break;
                                                            }
                                                        }
                                                        if($replace_src_allow){
                                                            $full_link = $GLOBALS['rdgr']['urlparts']['domain_X']. (str_replace('//','/',  $GLOBALS['rdgr']['urlparts']['path_X'].$full_link) );
                                                        }
                                                    }
                                                }
                                                //replace http(s) with sheme-less urls
                                                if(!empty($GLOBALS['rdgr']['schemeless'])){
                                                    $full_link=str_replace(  array('https://','http://'), '//', $full_link);
                                                }
                                                //replace github mime
                                                if(!empty($GLOBALS['rdgr']['rawgit_replace'])){
                                                    $full_link= str_replace('//raw.github'.'usercontent.com/','//rawgit.com/', $full_link);
                                                }
                                                $matches_B[2]=$full_link;
                                                unset($matches_B[0]);
                                                $content_B=''; foreach ($matches_B as $each){$content_B .= $each; }
                                                return $content_B;
                                            },
                                            $content_A
                                        );
                                    }
                                }
                            }
                            return $content_A;
                        },
                        $content
                    );
        
            $content= preg_replace_callback(
                        '/style="(.*?)background(\-image|)(.*?|)\:(.*?|)url\((\'|\"|)(.*?)(\'|\"|)\)/i',
                        function($matches_A){
                            $url = $matches_A[7];
                            $url = (substr($url,0,2)=='//' || substr($url,0,7)=='http://' || substr($url,0,8)=='https://' ? $url : '#');
                            return 'style="'.$matches_A[1].'background'.$matches_A[2].$matches_A[3].':'.$matches_A[4].'url('.$url.')'; //$matches_A[5] is url taged ,7 is url
                        },
                        $content
                    );
        }

        return $content;
    }



    public function urlToShortCode($url) 
    {
        if (empty($url)) 
        {
            throw new Exception("No URL was supplied.");
        }

        
        if ($this->validateUrlFormat($url) == false) 
        {
            throw new Exception(
                "URL does not have a valid format.");
        }

        if (self::$checkUrlExists) 
        {
            if (!$this->verifyUrlExists($url)) 
            {
                throw new Exception(
                    "URL does not appear to exist.");
            }
        }

        $shortCode = $this->urlExistsInDb($url);

        if ($shortCode == false) 
        {
            $shortCode = $this->createShortCode($url);
        }

        return $shortCode;
    }

    protected function validateUrlFormat($url) {
        return filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED);
    }

    protected function verifyUrlExists($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    protected function urlExistsInDb($url) 
    {
        $query = "SELECT short_code FROM " . self::$table .
            " WHERE long_url = :long_url LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url
        );
        $stmt->execute($params);

        $result = $stmt->fetch();

        return (empty($result)) ? false : $result["short_code"];
    }

    protected function createShortCode($url) {
        $id = $this->insertUrlInDb($url);
        $shortCode = $this->convertIntToShortCode($id);
        $this->insertShortCodeInDb($id, $shortCode);
        return $shortCode;
    }

    protected function insertUrlInDb($url) {
        $query = "INSERT INTO " . self::$table .
            " (long_url, date_created) " .
            " VALUES (:long_url, :timestamp)";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "long_url" => $url,
            "timestamp" => $this->timestamp
        );
        $stmnt->execute($params);

        return $this->pdo->lastInsertId();
    }

    protected function convertIntToShortCode($id) {
        $id = intval($id);
        if ($id < 1) {
            throw new Exception(
                "The ID is not a valid integer");
        }

        $length = strlen(self::$chars);
        // make sure length of available characters is at
        // least a reasonable minimum - there should be at
        // least 10 characters
        if ($length < 10) {
            throw new Exception("Length of chars is too small");
        }

        $code = "";
        while ($id > $length - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            $code = self::$chars[fmod($id, $length)] .
                $code;
            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }

        // remaining value of $id is less than the length of
        // self::$chars
        $code = self::$chars[$id] . $code;

        return $code;
    }

    protected function insertShortCodeInDb($id, $code) {
        if ($id == null || $code == null) {
            throw new Exception("Input parameter(s) invalid.");
        }
        $query = "UPDATE " . self::$table .
            " SET short_code = :short_code WHERE id = :id";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "short_code" => $code,
            "id" => $id
        );
        $stmnt->execute($params);

        if ($stmnt->rowCount() < 1) {
            throw new Exception(
                "Row was not updated with short code.");
        }

        return true;
    }

    public function shortCodeToUrl($code, $increment = true) {
        if (empty($code)) {
            throw new Exception("No short code was supplied.");
        }

        if ($this->validateShortCode($code) == false) {
            throw new Exception(
                "Short code does not have a valid format.");
        }

        $urlRow = $this->getUrlFromDb($code);
        if (empty($urlRow)) {
            throw new Exception(
                "Short code does not appear to exist.");
        }

        if ($increment == true) {
            $this->incrementCounter($urlRow["id"]);
        }

        return $urlRow["long_url"];
    }

    protected function validateShortCode($code) {
        return preg_match("|[" . self::$chars . "]+|", $code);
    }

    protected function getUrlFromDb($code) {
        $query = "SELECT id, long_url FROM " . self::$table .
            " WHERE short_code = :short_code LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params=array(
            "short_code" => $code
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result;
    }

    protected function incrementCounter($id) {
        $query = "UPDATE " . self::$table .
            " SET counter = counter + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "id" => $id
        );
        $stmt->execute($params);
    }


    public function long_code($code)
    {
        $link = Link::where('code','=', $code)->first();

        if ($link)
        {
            return redirect($link->link);
        }
    }

    private function get_amazon_data($url)
    {
        $data = array('title' => '', 'description' => '', 'image' => '', 'media_types' => array());

        $url = explode('/dp/', $url);

        if (isset($url[1]))
        {
            $codes = explode('/', $url[1]);

            $code = $codes[0];

            $parameters = array("Operation"   => "ItemSearch",
                                "Keywords"    => $code,
                                "ResponseGroup" => "Medium",
                                "SearchIndex" => "All");
                                
            $result = $this->queryAmazon($parameters);

            
            if ($result)
            {
                $media = MediaType::where('media_type','=', 'Product')->first();

                $data = array('title' => (string) $result->Items->Item->ItemAttributes->Title,
                             'description' => (string) $result->Items->Item->ItemAttributes->Feature,
                             'image' => (string) $result->Items->Item->LargeImage->URL,
                             'media_types' =>  $media->id
                         );
            }    


        } 

        return $data;

    }

    private function queryAmazon($parameters)
    {
        $public_key = Config::get('amazon.public_key');
        $secret_key = Config::get('amazon.secret_key');
        $associate_tag = Config::get('amazon.associate_tag');

        return $this->aws_signed_request("com", $parameters, $public_key, $secret_key, $associate_tag);
    }


    private function  aws_signed_request($region,$params,$public_key,$private_key,$associate_tag)
    {

        $method = "GET";
        $host = "ecs.amazonaws.".$region; // must be in small case
        $uri = "/onca/xml";
        
        
        $params["Service"]          = "AWSECommerceService";
        $params["AWSAccessKeyId"]   = $public_key;
        $params["AssociateTag"]     = $associate_tag;
        $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
        $params["Version"]          = "2009-03-31";

        /* The params need to be sorted by the key, as Amazon does this at
          their end and then generates the hash of the same. If the params
          are not in order then the generated hash will be different thus
          failing the authetication process.
        */
        ksort($params);
        
        $canonicalized_query = array();

        foreach ($params as $param=>$value)
        {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param."=".$value;
        }
        
        $canonicalized_query = implode("&", $canonicalized_query);

        $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
        
        /* calculate the signature using HMAC with SHA256 and base64-encoding.
           The 'hash_hmac' function is only available from PHP 5 >= 5.1.2.
        */
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));
        
        /* encode the signature for the request */
        $signature = str_replace("%7E", "~", rawurlencode($signature));
        
        /* create request */
        $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;

        /* I prefer using CURL */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $xml_response = curl_exec($ch);

        /* If cURL doesn't work for you, then use the 'file_get_contents'
           function as given below.
        */
        
        if ($xml_response === False)
        {
            return False;
        }
        else
        {
            echo "xxxx";
            /* parse XML */
            $parsed_xml = @simplexml_load_string($xml_response);
            return ($parsed_xml === False) ? False : $parsed_xml;
        }
    }

}
