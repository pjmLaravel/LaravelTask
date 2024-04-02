<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .hide {
            display: none
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>

    @if (Session::has('error')) 
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        @endif

    <form method="post" action="{{ route('register') }}">
        @csrf
        <div>
        <td> 이름 : 
        <input type="text" class="form-control" name = 'name'/>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </td><br>
        <td> 이메일 :
        <input type="text" class="form-control" name = 'email'/>
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
         @enderror
        </td><br>
        <td>
        비밀번호 :
        <input type="password" class="form-control" name ="password" id="password"   /> 
        <div class="alert alert-danger validation hide">비밀번호는 4자 이상 12자 이하입니다</div>
        </td><br>
        <br> </div>
        <button type="submit" class="alert alert-dark">회원가입</button>
        </form>

        <script>
            const elInputPassword = document.querySelector('#password');
            const validation = document.querySelector(".validation");
    
            elInputPassword.addEventListener('input', function () {
                // 비밀번호 길이 체크
                if (elInputPassword.value.length >= 4 && elInputPassword.value.length <= 12) {
                    validation.classList.add("hide");
                } else {
                    validation.classList.remove("hide");
                }
            });
        </script>
</body>
</html>
