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
    <form id="postForm">
        @csrf

        <label for="title">タイトル:</label>
        <input type="text" name="title" id="title">
        <div id="titleError"></div>

        <label for="message">投稿内容:</label>
        <textarea name="message" id="message"></textarea>
        <div id="messageError"></div>

        <button type="submit">投稿する</button>

    </form>

    <h2>ニュース一覧</h2>
    <div id="newsList">
    @foreach ($posts as $post)
        <h3><a href="{{ route('posts.show', $post->id) }}">タイトル：{{ $post->title }}</a></h3>
        <p>内容：{{ $post->message }}</p>
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
