<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Category;

class BlogController extends Controller
{
    protected $limit = 3;

    public function index() {
//        \DB::enableQueryLog();

        $categories = Category::with(['posts' => function($query) {
            $query->published();
        }])->orderBy('title', 'asc')->get();

        $posts = Post::with('author')
                ->latestFirst()
                ->published()
                ->simplePaginate($this->limit);
//        view('blog.index', compact('posts'))->render();
//        dd(\DB::getQueryLog());
        return view('blog.index', compact('posts', 'categories'));
    }

    public function category($id) {
        $categories = Category::with(['posts' => function($query) {
            $query->published();
        }])->orderBy('title', 'asc')->get();

        $posts = Post::with('author')
            ->latestFirst()
            ->published()
            ->where('category_id', $id)
            ->simplePaginate($this->limit);

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(Post $post) {
        return view('blog.show', compact('post','categories'));
    }
}
