<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Http\Requests\AddBlogRequest;
use App\Http\Requests\EditBlogRequest;
use App\Models\User;
use App\Models\Blog;
use App\Models\Todo;
use Session;
use Image;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function getProfile()
    {
        $user = Auth::user();

        return view('admin.profile')
                ->with('user', $user);
    }

    public function getBlog()
    {
        $user = Auth::user();

        return view('admin.blog')
                ->with('user', $user);
    }

    public function getAdminBlogData(Request $request){

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $blogs = Blog::where('user_id', $user->id)
                            ->orderBy('created_at','DESC');
            
            if($blogs) {

                return Datatables::of($blogs)
                ->editColumn('title', function ($blogs) {
                    return '<a href="'.url('/blog/'.$blogs->slug).'" target="_blank">'.$blogs->title.'</a>';
                })
                ->editColumn('category', function ($blogs) {
                    return $blogs->category;
                })
                ->editColumn('views', function ($blogs) {
                    return $blogs->views;
                })
                ->addColumn('date', function ($blogs) {
                    return date('F j, Y', strtotime($blogs->created_at)) . ' | ' . Carbon::parse($blogs->created_at)->diffForHumans();
                })
                ->addColumn('action', function ($blogs) {
                    return '<a href="'.url('/admin/edit/blog/'.$blogs->id).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>

                            <a ng-click="frm.deleteBlog('.$blogs->id.')"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>';
                })
                ->addIndexColumn()
                ->rawColumns(['title','category','views','date','action'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }  
    }

    public function getAddBlog()
    {
        $user = Auth::user();

        return view('admin.add_blog')
                ->with('user', $user);
    }

    public function postAddBlog(AddBlogRequest $request)
    {
        try{

            $user = Auth::user();

            $blog = new Blog;
            $blog->user_id = $user->id;
            $blog->title = $request->title;
            if ($request->hasFile('image')) {

                $blog_image = $request->file('image');
                $strippedName = str_replace(' ', '', $blog_image->getClientOriginalName());
                $photoName = date('Y-m-d-H-i-s').$strippedName;

                $blog_img = Image::make($blog_image->getRealPath())->resize(400, 400);
                $blog_img->save(public_path().'/images/blog/'.$photoName, 60);

                $blog->image = $photoName;
            }  
            $blog->category = $request->category;
            $blog->content = $request->content;
            $blog->save();

            Session::flash('success', 'Successfully added blog');
            return redirect('/admin/blog');

        } catch(\Exception $e) {
            
            Session::flash('danger', $e);
            return back();
        }

    }
    
    public function getEditBlog($blog_id)
    {
        $user = Auth::user();

        $blog = Blog::where('id', $blog_id)->first();

        return view('admin.edit_blog')
                ->with('blog', $blog)
                ->with('user', $user);
    }

    public function postEditBlog(EditBlogRequest $request, $blog_id)
    {
        try{

            $user = Auth::user();

            $blog = Blog::where('id', $blog_id)->first();
            $blog->title = $request->title;
            if ($request->hasFile('image')) {

                $blog_image = $request->file('image');
                $strippedName = str_replace(' ', '', $blog_image->getClientOriginalName());
                $photoName = date('Y-m-d-H-i-s').$strippedName;

                $blog_img = Image::make($blog_image->getRealPath())->resize(400, 400);
                $blog_img->save(public_path().'/images/blog/'.$photoName, 60);

                $blog->image = $photoName;
            }  
            $blog->category = $request->category;
            $blog->content = $request->content;
            $blog->slug = null;
            $blog->save();

            Session::flash('success', 'Successfully edited blog');
            return redirect('/admin/blog');

        } catch(\Exception $e) {
            
            Session::flash('danger', $e);
            return back();
        }

    }

    public function postDeleteBlog($blog_id)
    {
        $user = Auth::user();

        $blog = Blog::where('id', $blog_id)->first();

        if($blog){

            $file_path = public_path().'/images/blog/'.$blog->image;

            if(file_exists($file_path)){

                if(!empty($blog->image)){
                    unlink($file_path);
                }
                
            }

            $blog->delete();

            return response()->json(['status' => 'success', 'message' => 'Successfully delete blog'],200);
        }
        
        return response()->json(['status' => 'danger', 'message' => 'Something went wrong please try again!'],200);
        
    }

    public function getTodo()
    {
        $user = Auth::user();
        return view('admin.todo')
                ->with('user', $user);
    }

    public function getTodoData(Request $request) {

        $todos = Todo::with('user')->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'data' => $todos
        ], 200);
    }

    public function postAddTodo(Request $request) {

        try{

            if($request->wantsJson()) {

                $user = Auth::user();

                $todo = new Todo;
                $todo->user_id = $user->id;
                $todo->title = $request->task;
                $todo->save();

                return response()->json(['status' => 'success', 'message' => 'Successfully added task'], 200);
                
            } else {

                return response()->json(['status' => 'danger', 'message' => 'Something went wrong. Please try again!'],422);
            }

        } catch(\Exception $e) {

            return response()->json(['status' => 'danger', 'message'=> $e->getMessage()], 422);
            
        }
    }

    public function postCheckedTodo(Request $request, $task_id) {

        try{

            if($request->wantsJson()) {

                $user = Auth::user();

                $task = Todo::where('id', $task_id)->first();

                if(!$task){
                    return response()->json(['status' => 'danger', 'message' => 'Task doesnt exists'], 200);
                }

                $task->status = $request->checked_id;
                $task->save();

                return response()->json(['status' => 'success', 'message' => 'Successfully cheked task'], 200);
                
            } else {

                return response()->json(['status' => 'danger', 'message' => 'Something went wrong. Please try again!'],422);
            }

        } catch(\Exception $e) {

            return response()->json(['status' => 'danger', 'message'=> $e->getMessage()], 422);
            
        }
    }

    public function postDeleteTodo(Request $request, $task_id) {

        try{

            if($request->wantsJson()) {

                $user = Auth::user();

                $task = Todo::where('id', $task_id)->first();

                if(!$task){
                    return response()->json(['status' => 'danger', 'message' => 'Task doesnt exists'], 200);
                }

                $task->delete();

                return response()->json(['status' => 'success', 'message' => 'Successfully deleted task'], 200);
                
            } else {

                return response()->json(['status' => 'danger', 'message' => 'Something went wrong. Please try again!'],422);
            }

        } catch(\Exception $e) {

            return response()->json(['status' => 'danger', 'message'=> $e->getMessage()], 422);
            
        }
    }

    public function postEditTodo(Request $request, $task_id) {

        try{

            if($request->wantsJson()) {

                $user = Auth::user();

                $task = Todo::where('id', $task_id)->first();

                if(!$task){
                    return response()->json(['status' => 'danger', 'message' => 'Task doesnt exists'], 200);
                }

                $task->title = $request->task;
                $task->save();

                return response()->json(['status' => 'success', 'message' => 'Successfully edited task'], 200);
                
            } else {

                return response()->json(['status' => 'danger', 'message' => 'Something went wrong. Please try again!'],422);
            }

        } catch(\Exception $e) {

            return response()->json(['status' => 'danger', 'message'=> $e->getMessage()], 422);
            
        }
    }
}
