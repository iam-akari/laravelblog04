<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{

    /**
     * ブログ一覧を表示する
     * @return view
     */

    public function showList()
    {
        $blogs = Blog::all();
        return view('blog.list',['blogs'=>$blogs]);
    } 
}
