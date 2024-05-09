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
    <h1>詳細</h1>
    <p>タイトル:</p>
    <p>{{ $post->title }}</p>
    <p>内容:</p>
    <p>{{ $post->message }}</p>

    <form id="commentForm">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        コメント
        <p><textarea id="body" name="body" cols="50" rows="5"></textarea></p>
        <div id="commentError"></div>
        <input type="submit" value="投稿"> 
    </form>

    <div id="commentList">
        @foreach ($post->comments as $comment)
            <p>{{ $comment->body }}

            <form action="{{ route('comments.destroy',$comment->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">削除</button><br></p>
            </form> 
        @endforeach 
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#commentForm').submit(function(e) {
                e.preventDefault(); // デフォルトのフォーム送信を停止
    
                if (confirm('マジ投稿しちゃう？')) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('comments.store') }}',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#body').val(''); 
                            $('#commentError').empty();
                            // 投稿データから詳細ページへのリンクを生成
                            var newCommentHtml = '<p>コメント：' + response.comment.body + '</p>';
                            $('#commentList').prepend(newCommentHtml);              
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            $('#commentError').text(errors.title && errors.title[0]);
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