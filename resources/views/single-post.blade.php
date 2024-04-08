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
        }

        .dropdown-menu {
                display: none;
        }
        </style>
</head>
<body>
    @if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

@if (session('validator'))
    <script>
        alert('댓글 작성 오류입니다.');
    </script>
@endif

    <div class="container w-50">
        <div class="mt-4 mb-3">
            <span class="h2">게시판</span>
        </div>
        <div class="mb-2 mt-5">
          <p> <h3>작성자: {{ $post->name }} </h3></p>
        </div>
        <div class="mb-2 mt-3">
         <br> <br> {{ $post->subject }}
        </div>
        <div class="mt-5">
         <br> {!! $post->content !!}
        </div>
        @if (isset($post->img_path))
        <div class="mt-5">
            <img src="{{ asset($post->img_path) }}"  width="500" height="300">
        </div>
        @endif
        <div class="mt-5">
            <a href="{{ route('post.getallpost') }}" class="btn btn-secondary">글 목록으로</a>
        </div>

        {{-- (로그인 시) 댓글 작성 form --}}
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

        {{-- 비 로그인 시 댓글 작성 불가 --}}
    @else
    <div style="margin-top:55px">
        <span class="h5">댓글 작성</span>
    <textarea name="commentStory" cols="1" rows="5" class="form-control" style="resize: none" placeholder="로그인 시에 댓글 작성 가능합니다"></textarea>
    </div>
    <div style="margin-top:10px">
    <button class="btn btn-primary" onclick="test()">작성</button>
    </div>
    @endauth

    {{--  댓글 수 --}}
    <div class="mt-3">
        <h2>댓글 {{ $comment->count() }}</h2>
    </div>

   {{-- 댓글 목록 --}}
@if ($comment->count() > 0)
@foreach ($comment as $comments)
@if ($comments->topcomment_id === null)
    <div class="comment-container mb-5 mt-3">
        <div class="card" style="margin-bottom: 30px">
            <div class="card-body">
                <h5 class="card-title">{{ $comments->userName }}</h5>
                @if ($comments->userID == auth()->id())
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $comments->id }}">
                        수정
                    </button>
                    <form method="post" action="{{ route('comment.delete', $comments->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">삭제</button>
                    </form>
                @endif
                <p class="card-text">{{ $comments->commentStory }}</p>

                {{-- 대댓글 출력 --}}
                <h4 style="color: gray" class="mt-3">답글</h4>
                @foreach ($comment as $reply)
                    @if ($reply->topcomment_id == $comments->id)
                        <div class="card" style="width: 40rem;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">ㄴ {{ $reply->userName   . ' : ' .   $reply->commentStory }}</li>
                            </ul>
                        </div>
                    @endif
                @endforeach
                {{-- 대댓글 끝 --}}

                {{-- 답글 작성 --}}
                @auth
                    <div class="comment-container">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="replyDropdown{{ $comments->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                답글 작성
                            </button>
                            <form action="{{ route('comment.addreply') }}" method="POST" >
                                @csrf
                                <input type="hidden" name="topcomment_id" value="{{ $comments->topcomment_id ?? $comments->id }}"> <!-- topcomment_id를 hidden input으로 전달 -->
                                <input type="hidden" name="parent_id" value="{{$post->id}}">    <!-- 답글이 적힌 글의 id를 받아옴 -->
                                <ul class="dropdown-menu" aria-labelledby="replyDropdown{{ $comments->id }}">
                                    <li>
                                        <textarea class="form-control reply-textarea" name="commentStory" rows="3" style="resize: none"></textarea>
                                    </li>
                                    <li>
                                        <button type="submit" class="btn btn-success mt-2 submit-reply-btn">작성</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                @endauth
                {{-- 답글 작성 끝 --}}
            </div>
        </div>
    </div>
    @endif
@endforeach
@endif
      <!-- Modal -->
      @if ($comment->count() > 0)

      <div class="modal fade" id="staticBackdrop{{ $comments->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">댓글 수정하기</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('comment.update', $comments->id) }}">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comments->id }}">
                        <div style="margin-top:55px">
                            <span class="h5">댓글 수정</span>
                            <textarea name="commentStory" cols="1" rows="5" class="form-control" style="resize: none">{{ $comments->commentStory }}</textarea>
                        </div>
                        <div style="margin-top:10px">
                            <button class="btn btn-primary">작성</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- 모달 --}}




<script>
    function test() {
        if (confirm("로그인 시에만 댓글 작성 가능합니다. 로그인 하시겠습니까?")) {
            window.location.href = '/login-email'
        }
    }

    document.getElementById('replyDropdown').addEventListener('click', function(event) {
    event.preventDefault();
    this.nextElementSibling.classList.toggle('show');
});
</script>
</body>
</html>
