<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

class GalleryController extends Controller
{
    public function index()
    {
        // Make an API request to get gallery data
        $response = Http::get('http://127.0.0.1:8000/api/getGallery');

        // Check if the request was successful
        if ($response->successful()) {
            // Decode the JSON response
            $galleries = $response->json()['gallery'];

            // Additional data if needed
            $data = [
                'id' => 'posts',
                'menu' => 'Gallery',
                'galleries' => $galleries,
            ];

            // Return view with data
            return view('gallery.index')->with($data);
        } else {
            // Handle error, redirect, or show an error view
            return redirect()->back()->with('error', 'Failed to fetch gallery data from the API');
        }
    }
public function create()
{   
 return view('gallery.create');
}

public function store(Request $request)
{
 $this->validate($request, [
 'title' => 'required|max:255',
 'description' => 'required',
 'picture' => 'image|nullable|max:1999'
 ]);
 if ($request->hasFile('picture')) {
 $filenameWithExt = $request->file('picture')->getClientOriginalName();
 $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
 $extension = $request->file('picture')->getClientOriginalExtension();
 $basename = uniqid() . time();
 $smallFilename = "small_{$basename}.{$extension}";
 $mediumFilename = "medium_{$basename}.{$extension}";
 $largeFilename = "large_{$basename}.{$extension}";
 $filenameSimpan = "{$basename}.{$extension}";
 $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
 } else {
 $filenameSimpan = 'noimage.png';
 }
 // dd($request->input());
 $post = new Post;
 $post->picture = $filenameSimpan;
 $post->title = $request->input('title');
 $post->description = $request->input('description');
 $post->save();
 return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
}

}

