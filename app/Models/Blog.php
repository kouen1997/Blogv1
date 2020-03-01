<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Blog extends Model
{
    use Sluggable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_blog';

    public function sluggable(){
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

	public function user(){
		 return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

    public function blog(){
         return $this->belongsTo('App\Models\BlogViews', 'blog_id', 'id');
    }
}
