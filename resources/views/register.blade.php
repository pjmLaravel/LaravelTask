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
    </style>
</head>
<body>
    <form action="register.php" method="post">
        <h2>회원가입</h2>
        <label for="username">사용자명:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">이메일:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">비밀번호 확인:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">가입하기</button>
    </form>
</body>
</html>
