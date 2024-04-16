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


        .eyes {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            margin: auto 2px;
            height: 30px;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
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
                <input type="text" class="form-control" name = 'name' />
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </td><br>

            <td> 이메일 :
                <input type="text" class="form-control" name="email" id="email" oninput="validateEmail()" />
                <div id="emailError" class="alert alert-danger" style="display: none;"></div>

                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </td><br>

            <td>
                비밀번호 :
                <div class="input-group">
                    <input type="password" class="form-control" name ="password" id="password" />
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border: none;">
                        <i id="toggleIcon" class="bi bi-eye-slash"></i>
                    </button>
                </div>

                <div class="alert alert-danger validation hide">비밀번호는 4자 이상 12자 이하입니다</div>
            </td><br>
            <td>
                비밀번호 확인 :
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                    for="password" />
                <div class="alert alert-danger validation_confirmation hide">비밀번호가 일치하지 않습니다</div>
            </td><br>
            <br>
        </div>
        <button type="submit" class="alert alert-dark" id="btn_login" style="cursor: default" disabled>회원가입</button>
    </form>

    <script>
        const elInputPassword = document.querySelector('#password');
        const validation = document.querySelector(".validation");
        const elInputPasswordConfirmation = document.querySelector('#password_confirmation');
        const validationConfirmation = document.querySelector(".validation_confirmation");

        const togglePassword = document.querySelector('#togglePassword');
        const toggleIcon = document.querySelector('#toggleIcon');

        const idForm = document.querySelector('#email');
        const loginButton = document.querySelector('#btn_login');


        // 이메일 밸리데이션 체크
        function validateEmail() {
            var emailInput = document.getElementById('email');
            var email = emailInput.value;
            // var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var emailError = document.getElementById('emailError');

            if (!emailPattern.test(email) || email.trim() === '') {
                emailError.innerHTML = '이메일 형식이 올바르지 않습니다.';
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
                var email = $('#email').val();
                $.ajax({
                    url: '/emailCheck', // 컨트롤러에서 처리할 주소
                    type: 'POST', // POST 방식으로 요청
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "email": email // 이메일 데이터 전달
                    },
                    success: function(cnt) {
                        if (cnt !== 0) { // 중복된 경우
                            emailError.innerHTML = '이미 가입된 이메일입니다.';
                            emailError.style.display = 'block';
                        }
                    },
                    error: function(request, status, error) { // 에러 발생 시
                        const errorMsg = JSON.parse(request.responseText);
                        alert("ERROR CODE: " + request.status + "\n" +
                            "ERROR MESSAGE: " + errorMsg.message + "\n" +
                            "상태가 지속될 경우 관리자에게 문의해주세요");
                    }
                });
            }
        }

        // 여기까지
        elInputPassword.addEventListener('input', function() {
            // 비밀번호 길이 체크
            if (elInputPassword.value.length >= 4 && elInputPassword.value.length <= 12) {
                validation.classList.add("hide");
            } else {
                validation.classList.remove("hide");
            }
        });

        elInputPasswordConfirmation.addEventListener('input', function() {
            // 비밀번호 확인 체크
            if (elInputPassword.value === elInputPasswordConfirmation.value) {
                validationConfirmation.classList.add("hide")
                loginButton.disabled = false;
                loginButton.className = 'btn btn-primary'
                loginButton.style.cursor = "pointer"
            } else {
                validationConfirmation.classList.remove("hide");
                loginButton.disabled = true; // 비밀번호 확인이 일치하지 않으면 버튼 비활성화
                loginButton.className = 'alert alert-dark'
                loginButton.style.cursor = "default"
            }
        });

        // 비밀번호 보기 숨기기
        togglePassword.addEventListener('click', function() {
            const type = elInputPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            elInputPassword.setAttribute('type', type);
            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });




        // // 이메일 중복 확인
        // function checkEmail() {
        //     var email = $('#email').val();

        //     // AJAX 요청을 통해 이메일 중복 확인을 수행
        //     $.ajax({
        //         url: '/emailCheck', // 컨트롤러에서 처리할 주소
        //         type: 'POST', // POST 방식으로 요청
        //         data: {
        //             "email": email // 이메일 데이터 전달
        //         },
        //         success: function(cnt) { // 성공 시
        //             if (cnt == 0) { // 중복되지 않는 경우
        //                 $("#vaildEmail").text("사용할 수 있는 이메일입니다.").css("color", "green");
        //             } else { // 중복된 경우
        //                 $("#vaildEmail").text("이미 존재하는 이메일입니다.").css("color", "red");
        //                 alert("다른 이메일을 입력해주세요.");
        //                 $('#email').val(''); // 입력값 초기화
        //             }
        //         },
        //         error: function(request, status, error) { // 에러 발생 시
        //             const errorMsg = JSON.parse(request.responseText);
        //             alert("ERROR CODE: " + request.status + "\n" +
        //                 "ERROR MESSAGE: " + errorMsg.message + "\n" +
        //                 "상태가 지속될 경우 관리자에게 문의해주세요");
        //         }
        //     });
        // }

        // // 이메일 입력란의 포커스를 잃을 때(checkEmail 함수 호출)
        // $('#email').blur(function() {
        //     checkEmail();
        // });
    </script>
</body>

</html>
