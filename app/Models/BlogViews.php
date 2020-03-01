<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogViews extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_blog_views';

    public function blog(){
         return $this->hasOne('App\Models\Blog', 'blog_id', 'id');
    }
}
