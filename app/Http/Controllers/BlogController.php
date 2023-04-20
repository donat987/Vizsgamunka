<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{

    public function blogcomment(Request $request)
    {
        if (isset(Auth::user()->username)) {
            $evolutionsave = new Comment();
            $evolutionsave->userid = Auth::user()->id;
            $evolutionsave->blogid = $request->blogid;
            $evolutionsave->comment = $request->comment;
            $evolutionsave->save();
            return back();
        } else {
            return back()->with('error', 'Kérjük előbb jelentkezzen be!');
        }
    }
    public function show($link)
    {
        $sql = DB::table('blogs')
        ->select('blogs.news as news', 'blogs.id as id', 'blogs.name as name', 'blogs.summary as summary','users.file as file','users.firstname as firstname', 'users.lastname as lastname','blogs.created_at as date')
        ->join('users','users.id','=','blogs.userid')
        ->where('link','=',$link)
        ->first();
        $layout = Product::layout();
        $comment = DB::table('comments')
        ->select('users.username as username', 'comments.created_at as date', 'users.file as file', 'comments.comment as comment')
        ->join('blogs','blogs.id','=','comments.blogid')
        ->join('users','users.id','=','blogs.userid')
        ->where('blogs.id','=',$sql->id)
        ->get();
        return view("user.blog",compact('layout', 'sql', 'comment'));
    }
    public function blogs()
    {
        $sql = DB::table('blogs')
        ->select('*')
        ->where('active','=',1)
        ->orderBy('created_at','asc')
        ->paginate(16, ['*'], 'oldal');
        $layout = Product::layout();
        return view("user.blogs",compact('layout', 'sql'));
    }
    public function save(Request $request)
    {
        $save = new Blog();
        if ($request->file()) {
            $valid = $request->validate([
                'file' => 'required|mimes:img,png,jpg|max:2048',
            ]);
            $image = $valid['file'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path = '/public/blog/' . $filename;
            $file = '/storage/blog/' . $filename;
            $img = Image::make($image);
            /*$img->fit(500, 500, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
            });*/
            Storage::put($path, (string) $img->encode());
            $save->name = request("name");
            $save->summary = request("minicontent");
            $save->news = request("content");
            $save->file = $file;
            $save->userid = Auth::user()->id;
            $save->active = 1;
            $save->link = "";
            $save->save();
            $id = $save->id;
            $link = $save->id . "_";
            $darabol = explode(" ", request("name"));
            $db = 0;
            foreach ($darabol as $i) {
                if ($db == 0) {
                    $db = 1;
                    $link .= $i;
                } else {
                    $link .= "_" . $i;
                }
            }
            DB::update('update blogs set link = "' . $link . '" where id = "' . $save->id . '"');

            return back()
                ->with('success', 'Sikeres mentés');
        }
    }
    public function blog()
    {
        return view("admin.blog");
    }
}
