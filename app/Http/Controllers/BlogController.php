<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
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
