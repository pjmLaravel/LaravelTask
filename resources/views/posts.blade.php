<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
      .logout:hover {
        text-decoration: underline; 
      }
      .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
  </head>
<body>
  <div>
@if(session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif

@if (Session::has('post_delete'))
<div class="alert alert-success" role="alert">
    {{ Session::get('post_delete') }}
</div>
@endif

@if (Session::has('post_create'))
<div class="alert alert-success" role="alert">
    {{ Session::get('post_create') }}
</div>
@endif


    {{-- {{ dd(Auth::user()) }} --}}

   
    @guest   
    {{-- <a href="{{ route('login.kakao') }}">
    <img src="/image/kakao.png" alt="카카오 로그인 이미지" style="margin-left:1000px; margin-top:30px">
    </a> --}}
    <div style="margin-left:1100px; margin-top:60px">
    <a href="{{ route('login.login') }}" class="btn btn-sm btn-secondary">로그인</a>
    </div>  
  @endguest
</div>
<div style="margin-left:1100px; margin-top:50px">
  @auth
  <form action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <div>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="logout">로그아웃</a>
    </div>
  </form>
@endauth
</div>

@auth
<div style="margin-left:1000px; margin-top-5px">
    <p class="h4 mt-3" >{{ auth()->user()->name }} 님, 안녕하세요</p>
  </div> 
    @else
    <div style="margin-left:1000px">
    <p class="h4 mt-1">Guest님, 안녕하세요</p>  
    </div>
     @endauth
</div>


  <div class="container w-50 mt-5"> 
  
    <table class="table">
      <thead>
        <tr>
          <th>작성자</th>
          <th>제목</th>
          {{-- <th>내용</th> --}}
          <th>처리</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $post)
        <tr>
  
          <td>{{$post->name}}</td>
          <td>{{$post->subject}}</td>
          
          {{-- <td>{!! $post->content !!}</td> --}}
        
          <td>
            
            @if ($post->user_id == $loggedInUserId)
            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-sm btn-warning">수정</a>
            @endif
            <a href="{{ route('post.getbyid',$post->id) }}" class="btn btn-sm btn-primary">보기</a>
            <!-- 삭제 모달 버튼-->
            @if ($post->user_id == $loggedInUserId)
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              삭제
            </button>

            <!-- Modal -->  
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">게시글 삭제</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    게시글을 삭제하시겠습니까? 
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <a href="{{ route('post.delete',$post->id) }}" class="btn btn-sm btn-danger">삭제</a>
                  </div>
                </div>
              </div>
            </div>
            
            {{-- <a href="{{ route('post.delete',$post->id) }}" class="btn btn-sm btn-danger">삭제</a> --}}
            @endif
          </td>
          
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $posts->links() }}

    <a href="{{ route('post.add') }}" class="btn btn-sm btn-link">글 작성하기</a>
  
 
 
  </div>
  <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
</body>
</html>