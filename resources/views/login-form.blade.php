<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
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

        .signup-link {
            text-align: center;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    @if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

    <form action="{{ route('login') }}" method="post">
        
        @csrf

        <h2>로그인</h2>
        이메일:
        <input type="email" id="email" name="email" required>
        비밀번호:
        <input type="password" id="password" name="password" required>
        <div class="signup-link">
            <p>계정이 없으신가요? <a href="{{ route('login.registerForm') }}">회원가입</a></p>
            <div style="margin-top: -9px">
            <a href="{{ route('login.kakao') }}" style="margin-top:10px">
            <img src="images/kakao.png" alt="카카오 로그인 이미지">
            </a>
        </div>
        </div>
        <button type="submit" style="margin-top:20px">로그인</button>
    </form>
</body>
</html>
