<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>공지사항</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

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
    @if (session('success'))
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
        <div class="mt-4 mb-3" style="text-align:center">
            <span class="h2"><strong><a href="{{ route('notice') }}">공지사항</a></strong></span>
        </div>
        <div class="mb-2 mt-5">
            <p>
            <h5 style="text-align:right">작성자: 관리자 </h5>
            </p>
        </div>
        <div class="mb-2 mt-3">
            <br> <br> {{ $notice->subject }}
        </div>
        <div class="mt-5">
            <br> {!! $notice->content !!}
        </div>

        <div class="mt-5">
            <a href="{{ route('notice') }}" class="btn btn-secondary">공지사항 목록으로</a>
        </div>
    </div>



</body>

</html>
