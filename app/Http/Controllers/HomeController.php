<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    //
    public function index()
    {
        $contents = Content::where('page', '=', 'home')->get();
        $data = [
            'contents' => $contents
        ];
        return view('home.index')->with($data);
    }
    public function aboutus()
    {
        //aboutus
        $contents = Content::where('page', '=', 'aboutus')->get();
        $data = [
            'contents' => $contents
        ];
        return view('home.about-us')->with($data);
    }
    public function profile()
    {
    }
}
