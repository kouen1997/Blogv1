<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use Session;
use Image;
use Carbon\Carbon;

class HomeController extends Controller
{
	public function getHome(){
        
        $blogs = Blog::orderBy('created_at', 'DESC')->take(5)->get();
        return view('welcome', compact('blogs'));

	}

    public function getVideos(){
        
        return view('videos');

    }
}