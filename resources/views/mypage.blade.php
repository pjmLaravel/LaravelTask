<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>마이페이지</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-top: 50px; /* 위에 여백 */
            margin-bottom: 50px; /* 아래 여백 */
        }

        .card-title,
        .card-text {
            line-height: 3.5; /* 글자 간격 조절 */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">마이페이지</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title" style="text-align: center">내 정보</h3>
                        <div style="display: flex">
                            <p class="card-text">이름 :</p>
                            <input type="text" class="form-control form-control-xs" style="margin-left: 15px; width:50%; height:100%; padding: 1rem .75rem;">
                        </div>

                        <p class="card-text">이메일 : johndoe@example.com</p>
                        <a href="#" class="btn btn-primary">수정</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
