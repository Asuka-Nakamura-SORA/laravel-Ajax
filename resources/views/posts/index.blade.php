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
        <div class="form">
            @csrf
            <p>タイトル</p>
            <input type="text" name="title" id="title"/>
            <div id="titleError"></div>
            <br/>
            <p>本文</p>
            <textarea name="message" id="message"></textarea>
            <div id="messageError"></div>
            <br/>         
        </div>
        <div class="buttun">
            <input type="submit" value="投稿">
        </div>
        <h3>一覧</h3>
    </form>

    <div id="newsList">
        @foreach ($posts as $post)
            <p>タイトル：{{ $post->title }}</p>
            <p>内容：{{ Str::limit( $post->message , 20,'...') }}</p>
            <a href="{{ route('posts.show', $post->id) }}">詳しく見せるよん<br><br></a>
        @endforeach
    </div>

    

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
                        $('#titleError').empty();
                        $('#messageError').empty();
                        var newPostHtml = '<h3><a href="' + '/posts/' + response.post.id + '">タイトル：' + response.post.title + '</a></h3><p>内容：' + response.post.message + '</p>';
                        $('#newsList').prepend(newPostHtml);                   
                    }    ,
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('#titleError').text(errors.title && errors.title[0]);
                        $('#messageError').text(errors.message && errors.message[0]);
                    }
                
                });
            } else {
                return false;
            }
        });
    });
</script>

</body>
</html>
