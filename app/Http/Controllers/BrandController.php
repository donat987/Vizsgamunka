<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:img,png,jpg|max:2048'
        ]);
        $save = new Brand();
        if ($request->file()) {
            $renames = time() . '_' . rand() . $request->file->getClientOriginalName();
            $picture = $request->file('file')->storeAs('brand', $renames, 'public');
            $save->name = request("name");
            $save->picturename = $renames;
            $save->file = "/storage/" . $picture;
            $save->save();
            return back()
                ->with('success', 'Sikeres mentés')
                ->with('file', $picture);
        }
    }
}
