<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function follow()
    {
    	return $this->belongsToMany('App\LinksFollow');
    }

    public function category()
    {
        return $this->belongsToMany('App\Category', 'link_categories', 'link_id', 'category_id');
    }


    public function stack()
    {
        return $this->belongsTo('App\Stack');
    }

    public function media()
    {
        return $this->belongsTo('App\MediaType');
    }

    public function get_host($link)
    {
        $url = parse_url($link);

        return $url['host'];
    }


    public function get_image($image)
    {
        $url = parse_url($image);
        
        if (strpos($image, 'http') === false)
        {
            $image = sprintf("%s://%s/%s", $url['scheme'], $url['host'], $image);
        }    
        
        return $image;
        
    }


    public function comments()
    {
        return $this->hasMany('App\LinkComment');
    }

    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";

    public function convertIntToShortCode() 
    {
        $random_string = "";

        $numeric = false;

        $not_exists = true;

        while ($not_exists)
        {
            $length = 10;

            while(strlen($random_string) < $length && $length > 0) 
            {
                if($numeric === false) 
                {
                    $randnum = mt_rand(0,61);

                    $random_string .= ($randnum < 10) ? chr($randnum+48) : ($randnum < 36 ?  chr($randnum+55) : $randnum+61);
                } 
                else 
                {
                    $randnum = mt_rand(0,9);
                    $random_string .= chr($randnum+48);
                }
            }
            
            $not_exists = $this->where('code', '=', $random_string)->get()->toArray();    

            
        }

        return $random_string;
        
    }
}
