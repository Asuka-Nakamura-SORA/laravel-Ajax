<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div class="background">
    <h1><a href="{{ route('posts.index') }}">Laravel News</a></h1> {{-- index.blade.phpへのリンク --}}
    <form action="{{ route('posts.store')}}" method="POST" id="postForm">
        @csrf

        <label for="title">タイトル:</label>
        <input type="text" name="title" id="title">
        @error('title')
            <div class="alert">{{ $message }}</div>
        @enderror

        <label for="message">投稿内容:</label>
        <textarea name="message" id="message"></textarea>
        @error('message')
            <div class="alert">{{ $message }}</div>
        @enderror

        <button type="submit">投稿する</button>
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

    <h2>ニュース一覧</h2>
<div id="newsList">
    @foreach ($posts as $post) {{-- PostControllerのindexメソッド内の「$posts」を受け取る --}}    
        <h3><a href="{{ route('posts.show', $post->id) }}">タイトル：{{ $post->title }}</h3>
                <div id="titleError"></div>
        内容：{{ Str::limit( $post->message , 20,'...') }}</p>
        <div id="messageError"></div>
        <td><a href="{{ route('posts.show', $post->id) }}">詳しく見せるよん<br><br></a></td>
        <br>
    @endforeach
    
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#postForm').submit(function(e) {
            e.preventDefault(); // デフォルトのフォーム送信を停止

            if (confirm('マジ投稿しちゃう？')) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('posts.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#title').val('');
                        $('#message').val('');                   
        }               
    });
            } else {
                return false;
            }
        });
    });

    success: function(response) {
        $('#title').val('');
        $('#message').val('');

     // 投稿データから詳細ページへのリンクを生成
        var newPostHtml = '<h3><a href="' + '/posts/' + response.post.id + '">タイトル：' + response.post.title + '</a></h3><p>内容：' + response.post.message + '</p>';
        $('#newsList').prepend(newPostHtml);
}

</script>

</body>
</html>
