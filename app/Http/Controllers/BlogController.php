<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogViews;
use Session;
use Image;
use Carbon\Carbon;

class BlogController extends Controller
{
	public function getViewBlog($slug){
        $device_ip = \Request::ip();

        $blog = Blog::where('slug', $slug)->first();

        if($blog){

            $ip_exists = BlogViews::where('user_id', $device_ip)->where('blog_id', $blog->id)->exists();

            if(!$ip_exists){

                $blog->increment('views');

                $views = new BlogViews;
                $views->user_id = $device_ip;
                $views->blog_id = $blog->id;
                $views->save();

            }
           	
           	dd($blog);

        }else{

        	abort(404);
        }

	}
}