@extends('auth.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css">
    <style>
        #confirm-btn {
            border-radius: 2rem;
            padding: 0.5rem 0;
        }

        #title {
            font-size: 2rem;
            color: #2250A3;
        }
    </style>

    <div class="container">
        <div class="row h-100 justify-content-center flex-column align-items-center">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-flex flex-column align-content-center justify-content-center">
                            <img src="{{ asset('images/linn.png') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-3">
                                <div class="text-center">
                                    <h1 id="title" class="h4 mb-4 font-weight-bold">Linn Training</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('login') }}" id="login_ele">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="text"
                                            class="form-control col-md-8 offset-md-2 @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Enter your email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password"
                                            class="form-control col-md-8 offset-md-2 @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password"
                                            placeholder="Enter your password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control col-md-8 offset-md-2 custom-checkbox small">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-8 offset-md-2" id="error">
                                        <span class="text-danger">* <span id="error-text">Your account has been
                                                locked</span></span>
                                    </div>
                                    <button type="button" id="submit-btn"
                                        class="btn btn-primary btn-user btn-block col-md-8 offset-md-2">
                                        {{ __('Login') }}
                                    </button>
                                    <div class="form-group mt-3 col-md-8 offset-md-2">
                                        <div class="d-flex justify-content-center">
                                            <small>
                                                <a href="{{ route('forgot_password') }}"
                                                    class="text-sm text-primary p-0">Forgotten password?</a>
                                            </small>
                                        </div>
                                    </div>

                                </form>

                                <form action="" method="POST" id="otp_ele" style="display: none;">
                                    @csrf
                                    <p id="email-alert" class="text text-primary col-md-8 offset-md-2"><span
                                            id="type">Email</span> OTP Verification</p>
                                    <div class="form-group p-0">
                                        <input id="otp" type="number" class="form-control col-md-8 offset-md-2 mb-2"
                                            name="otp" required autocomplete="off" placeholder="OTP">

                                        <div id="sms-otp-text" class="col-md-8 offset-md-2">
                                            <small class="text-primary">We will send sms otp to <span id="phone"
                                                    class="text-success"></span>, </small>
                                            <div><small class="text-primary">please resolve recaptcha to send otp.</small>
                                            </div>
                                        </div>

                                        <div class="col-md-8 offset-md-2" id="success-otp-send">
                                            <small style="color:green;">OTP has been send to your phone number</small>
                                        </div>


                                        <div class="col-md-8 offset-md-2">
                                            <div id="recaptcha-container"></div>
                                        </div>

                                        <span class="text-danger col-md-8 offset-md-2" id="otp_error">
                                            <span>* Invalid OTP Code</span>
                                        </span>
                                    </div>
                                    <button type="button" id="confirm-btn"
                                        class="btn btn-primary col-md-8 offset-md-2 btn-user btn-block">
                                        Confirm
                                    </button>
                                </form>
                                {{-- <div class="text-center">
                                <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{('register')}}">Create an Account!</a>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
{{-- Jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // init
    $(document).ready(function() {


        // Success Alert
        @if (Session::has('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ Session::get('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        // init
        $("#error").hide();
        $("#otp_ele").hide();
        $("#otp_error").hide();
        $("#sms-otp-text").hide();
        $("#success-otp-send").hide();

        var CURRENT_LOGIN_TYPE;






        $('#login_ele').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault(); // prevent the default form submission
                $("#submit-btn").click();

                if ($('form').attr('id') == 'otp_ele') {
                    $("#confirm-btn").click();
                }
            }
        });

        $('#otp_ele').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault(); // prevent the default form submission
                $("#confirm-btn").click();
            }
        });

        // Ajax login
        $("#submit-btn").on("click", function() {

            $(this).attr('disabled', 'disabled');
            $(this).text('Processing..');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            let email = $("#email").val();
            let password = $("#password").val();

            $.ajax({
                type: "GET",
                url: "{{ route('ajax_login') }}",
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    if (response.status) {

                        // Normal Force Login
                        if (response.type == "direct") {
                            window.location.href = response.redirect_to;
                        }

                        // Email Login
                        if (response.type == "email") {
                            // set value
                            CURRENT_LOGIN_TYPE = "email";
                            $("#otp_ele").show();
                            $("#login_ele").hide();
                            $("#type").text('Email');
                        }

                        if (response.type == "smsgo") {
                            // set value
                            CURRENT_LOGIN_TYPE = "smsgo";
                            $("#otp_ele").show();
                            $("#login_ele").hide();
                            $("#type").text('SMS');
                        }

                        // SMS OTP Login
                        if (response.type == "firebase") {
                            // set value
                            CURRENT_LOGIN_TYPE = "firebase";
                            $("#type").text('SMS');
                            $("#otp_ele").show();
                            $("#login_ele").hide();
                            $("#sms-otp-text").show();
                            $("#phone").text(response.phone);

                            firebase.auth().signInWithPhoneNumber(response.phone,
                                    appVerifier)
                                .then(function(confirmationResult) {
                                    // SMS sent. Prompt user to type the code from the message, then sign the
                                    // user in with confirmationResult.confirm(code).
                                    $("#recaptcha-container").hide();
                                    $("#sms-otp-text").hide();
                                    $("#success-otp-send").show();

                                    console.log(confirmationResult);
                                    window.confirmationResult = confirmationResult;
                                }).catch(function(error) {
                                    // Error; SMS not sent
                                    // ...
                                    console.log(error);
                                });
                        }


                    } else {
                        $("#error").show();
                        $("#error-text").text(response.message);

                        setTimeout(() => {
                            $("#error").hide();
                        }, 3500);

                        $('#submit-btn').attr('disabled', false);
                        $('#submit-btn').text('Login');
                    }
                }
            });
        });

        // Ajax Validate OTP 
        $("#confirm-btn").on("click", function() {
            $("#confirm-btn").attr('disabled', 'disabled');
            $("#confirm-btn").text('Processing..');

            // Email Validation Rule
            if (CURRENT_LOGIN_TYPE == "email" || CURRENT_LOGIN_TYPE == "smsgo") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                let email = $("#email").val();
                let otp = $("#otp").val();
                let password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax_check_otp') }}",
                    data: {
                        email: email,
                        otp: otp,
                        password: password
                    },
                    success: function(response) {
                        //   console.log(response);
                        if (response.status) {
                            window.location.href = response.redirect_to;
                        } else {
                            $("#otp_error").show();
                            $("#otp").val("");
                            setTimeout(() => {
                                $("#otp_error").hide();
                            }, 2000);
                            $("#confirm-btn").attr('disabled', false);
                            $("#confirm-btn").text('Confirm');
                        }
                    }
                });
            }


            //  Firebase Validation Rule
            if (CURRENT_LOGIN_TYPE == "firebase") {

                var code = $('#otp').val();

                if (code == "") {
                    $("#otp_error").show();
                    $("#otp").val("");
                    setTimeout(() => {
                        $(this).text('Confirm');
                        $("#otp_error").hide();
                    }, 2000);

                    $("#confirm-btn").attr('disabled', false);
                    $("#confirm-btn").text('Confirm');
                }

                confirmationResult.confirm(code).then(function(result) {
                    // Success

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    var email = $("#email").val();
                    var password = $("#password").val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('ajax_normal_login') }}",
                        data: {
                            email: email,
                            password: password
                        },
                        success: function(response) {
                            //   console.log(response);
                            if (response.status) {
                                window.location.href = response.redirect_to;
                            } else {
                                $("#otp_error").show();
                                $("#otp").val("");
                                setTimeout(() => {
                                    $("#otp_error").hide();
                                }, 2000);
                                $("#confirm-btn").attr('disabled', false);
                                $("#confirm-btn").text('Confirm');
                            }
                        }
                    });
                }.bind($(this))).catch(function(error) {

                    // User couldn't sign in (bad verification code?)
                    // ...
                    $("#otp_error").show();
                    $("#otp").val("");
                    setTimeout(() => {
                        $(this).text('Confirm');
                        $("#otp_error").hide();
                    }, 2000);

                    $("#confirm-btn").attr('disabled', false);
                    $("#confirm-btn").text('Confirm');
                }.bind($(this)));
            }


        });
    });
</script>
