<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>게시글 작성</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
</head>
<body>
    <div class="container w-50">
        @if (Session::has('post_create'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('post_create') }}
        </div>
        @endif
        <form action="{{route('post.addSubmit')}}" autocomplete="off" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="mt-4 mb-3">
                <span class="h2">게시판</span>
            </div>
            <div class="mb-2">
                <input type="hidden" name="userId" value="">
                <input type="text" name="subject" class="form-control" placeholder="제목을 입력하세요">
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <div>
                {{-- 에디터 --}}
                <textarea name="content" id="editor"></textarea>
                {{-- <textarea name="content" id="editor" cols="30" rows="10" class="form-control" style="resize: none"></textarea> --}}
            </div>
            <div class="mt-2">
                <button class="btn btn-primary">글등록</button>
                <a href="{{ route('post.getallpost') }}" class="btn btn-secondary">목록</a>
            </div>
        </form>
    </div>
    {{-- 에디터 --}}

    <script>

       ClassicEditor
    .create(document.querySelector('#editor'), {
        ckfinder: {
            uploadUrl: '{{ route('ckeditor.upload').'?_token='.csrf_token() }}'
        },
    })
    .catch(error => {
        console.error(error);
    });
    </script>
</body>
</html>
