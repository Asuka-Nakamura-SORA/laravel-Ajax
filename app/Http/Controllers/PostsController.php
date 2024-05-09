<?php
namespace App\Http\Controllers;
use App\Models\Post; // Postモデルを使用するために追加
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all(); // postsテーブルに保存されているデータをすべて取得
        return view('posts.index',compact('posts')); // views/posts/index.blade.php を表示する
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        // フォームから送られてきたデータをそれぞれ代入
        $post->title = $request->title;
        $post->message = $request->message;
        // データベースに保存
        $post->save();
        // indexページへ遷移
        return response()->json(['post' => $post]);
    }
    
    public function show($id)
    {
        $post = Post::find($id);

        return view('posts.show', compact('post'));
    }
}
