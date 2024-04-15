<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/search.css' rel='stylesheet'>
    <style>
      .logout:hover {
        text-decoration: underline;
      }
      .ck-editor__editable_inline {
            min-height: 300px;
        }

	@media (max-width: 1000px) {
	body {
		width: 170%;
	}

	.out {
		margin-left:170px !important;
		margin-bottom: -250px;
}
	.outrow {
		margin-left:200px !important;
}
	.hello {
		margin-left:200px !important;
		margin-top: 200px !important;
}
	.helloGuest {
		margin-left:250px !important;
		margin-top:250px;
}

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
    @guest
    <div style="margin-left:1100px; margin-top:60px" class="out">
    <a href="{{ route('login.login') }}" class="btn btn-sm btn-secondary">로그인</a>
    </div>
  @endguest
</div>
<div style="margin-left:1100px; margin-top:50px" class="out">
  @auth
  <form action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <div>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="logout">로그아웃</a>
    </div>
  </form>
@endauth
</div>

{{-- 로그인 된 경우 --}}
@auth
<div class="outrow">
<div style="margin-left:1000px; margin-top-5px" class="hello">
    <p class="h4 mt-3" >{{ auth()->user()->name }} 님, 안녕하세요</p>
  </div>
  {{-- 비 로그인일 경우 --}}
    @else
    <div style="margin-left:1000px" class="helloGuest">
    <p class="h4 mt-1">Guest님, 안녕하세요</p>
    </div>
     @endauth
</div>

</div>

  <div class="container w-50 mt-5">
    <div class="input-group">
        <div class="form-outline" data-mdb-input-init>
        <form action="{{ route('post.getallpost') }}" method="get">
            <input type="text" class="form-control-sm" name="search" placeholder="{{ $search ?? '검색' }}" id="search">
        </div>
            <button class="btn btn-primary" data-mdb-ripple-init>
                <i class="gg-search"></i>
            </button>
        </form>
        <div class="btn-group" style="margin-left: 15px">
            <button class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              게시글
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('post.getallpost') }}">게시글</a></li>
                <li><a class="dropdown-item" href="{{ route('notice') }}">공지사항</a></li>
            </ul>
          </div>

          {{-- 검색 div 끝 --}}
    </div>



    <table class="table">
      <thead>
        <tr>
          <th>작성자</th>
          <th>제목</th>
          <th>작성 시간</th>
          <th>처리</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $post)
        <tr>

          <td>{{$post->name}}</td>
          <td>{{$post->subject}}</td>
          {{-- <td>{{ $post->created_at->diffForHumans() }}</td> --}}
          <td>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</td>
          {{-- <td>{!! $post->content !!}</td> --}}

          <td>

            @if ($post->user_id == $loggedInUserId)
            <a href="{{ route('post.edit',$post->id) }}" class="btn btn-sm btn-warning">수정</a>
            @endif
            <a href="{{ route('post.getbyid',$post->id) }}" class="btn btn-sm btn-primary">보기</a>
            <!-- 삭제 모달 버튼-->
            @if ($post->user_id == $loggedInUserId)
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $post->id }}">
                삭제
              </button>

<!-- Modal -->
<div class="modal fade" id="deleteModal{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
          <form method="post" action="{{ route('post.delete',$post->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">삭제</button>
        </form>
        </div>
      </div>
    </div>
  </div>
            @endif
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $posts->links() }}

    <a href="{{ route('post.add') }}" class="btn btn-sm btn-link">글 작성하기</a>
    <a href="{{ route('post.getallpost') }}" class="btn btn-secondary">글 목록으로</a>



  </div>
  {{-- 여기 --}}
</div>
<script>
    // 페이지가 로드될 때 로컬 스토리지에서 선택한 값을 가져와서 버튼에 설정
    document.addEventListener('DOMContentLoaded', function() {
      const selectedValue = localStorage.getItem('selectedValue');
      if (selectedValue) {
        document.getElementById('dropdownMenuButton').textContent = selectedValue;
      }
    });

    // 드롭다운 아이템 클릭 시 선택한 값을 로컬 스토리지에 저장하고 버튼에 설정하는 함수
    document.querySelectorAll('.dropdown-item').forEach(item => {
      item.addEventListener('click', function() {
        const selectedValue = this.textContent;
        localStorage.setItem('selectedValue', selectedValue);
        document.getElementById('dropdownMenuButton').textContent = selectedValue;
      });
    });
  </script>
  <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
</body>
</html>
