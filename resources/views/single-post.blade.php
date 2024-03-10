<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        .comment-container {
            margin-top: 20px;
        };
        </style>
</head>
<body>
    <div class="container w-50">
        <div class="mt-4 mb-3">
            <span class="h2">게시판</span>
        </div>
        <div class="mb-2 mt-5">
          <h4> 작성자: {{ $post->name }} </h2>
        </div>
        <div class="mb-2 mt-5">
           <h5 class="font-weight-bold"> 제목 : {{ $post->subject }} </h2>
        </div>
        <div class="mt-3">
            {{ $post->content }}
        </div>
        <div class="mt-5">
            <a href="{{ route('post.getallpost') }}" class="btn btn-secondary">글 목록으로</a>
        </div>

        {{-- 댓글 작성 form --}}
        @auth
    <div class="w-4/5 mx-auto mt-6 text-right">
    <form method="post" action="{{route('comment.add')}}">
        @csrf
        <input type="hidden" name="parent_id" value="{{$post->id}}">
        
        <div style="margin-top:55px">
            <span class="h5">댓글 작성</span>
        <textarea name="commentStory" cols="1" rows="5" class="form-control" style="resize: none" placeholder="댓글을 입력하세요."></textarea>
        </div>
        <div style="margin-top:10px">
        <button class="btn btn-primary">작성</button>
        </div>
    </form>
    @else
    <div style="margin-top:55px">
        <span class="h5">댓글 작성</span>
    <textarea name="commentStory" cols="1" rows="5" class="form-control" style="resize: none" placeholder="로그인 시에 댓글 작성 가능합니다"></textarea>
    </div>
    <div style="margin-top:10px">
    <button class="btn btn-primary">작성</button>
    </div>
    @endauth
    <div class="mt-3">
        <h2>댓글 {{ $comment->count() }}</h2>
    </div>
    @foreach ($comment as $item)
    <div class="comment-container mb-5 mt-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $item->userName }}</h5>
                <p class="card-text">{{ $item->commentStory }}</p>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>