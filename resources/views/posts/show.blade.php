<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>詳細</h1>
    <p>タイトル:</p>
    <p>{{ $post->title }}</p>
    <p>内容:</p>
    <p>{{ $post->message }}</p>

    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        コメント
        <p><textarea name="body" cols="50" rows="5"></textarea></p>
        <input type="submit" value="投稿" onclick='return confirm("本当に投稿しますか？")'> 
    </form>
    
    @if ($errors->any())
        {{-- エラーメッセージ --}}
        <div class="error">
            {!! implode('<br>', $errors->all()) !!}
        </div>
        @elseif (session()->has('success'))
        {{-- 成功メッセージ --}}
        <div class="success">
            {{ session()->get('success') }}
        </div>
    @endif

    @foreach ($post->comments as $comment) {{-- CommentControllerのindexメソッド内の「$comments」を受け取る --}}
        <p>{{ $comment->body }}
            
        <form action="{{ route('comments.destroy',$comment->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" onclick='return confirm("本当にkesu？");'>削除</button><br></p>
        </form>  
    @endforeach
    

</body>
</html>