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

    @if(Auth::guard('admin')->check())
    <div style="margin-left:1100px; margin-top:50px" class="out">
      <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
          @csrf
          <div>
          <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="logout">로그아웃</a>
        </div>
      </form>
    </div>
    @endif



  <div class="container w-50 mt-5">
    <div class="input-group">
        <div class="form-outline" data-mdb-input-init>
        <form action="{{ route('admin.dashboard') }}" method="get">
            <input type="text" class="form-control-sm" name="search" placeholder="{{ $search ?? '검색' }}" id="search">
        </div>
            <button class="btn btn-primary" data-mdb-ripple-init>
                <i class="gg-search"></i>
            </button>
        </form>
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


            <a href="{{ route('post.getbyid',$post->id) }}" class="btn btn-sm btn-primary">보기</a>
            <!-- 삭제 모달 버튼-->

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
          <form method="post" action="{{ route('admin.delete',$post->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">삭제</button>
        </form>
        </div>
      </div>
    </div>
  </div>

          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $posts->links() }}
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">글 목록으로</a>



  </div>
  {{-- 여기 --}}
</div>
  <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
</body>
</html>
