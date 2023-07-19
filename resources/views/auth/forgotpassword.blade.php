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
        <div class="row justify-content-center flex-column align-items-center">
            <div class="card o-hidden border-0 shadow-lg my-5 col-md-8">
                <div class="card-body p-5 d-flex justify-content-center flex-lg-column align-content-center">
                    <div class="col-12">
                        <div class="p-3">
                            <div class="text-center">
                                <h1 id="title" class="h4 mb-2 font-weight-bold">Forgotten password?</h1>
                            </div>
                            <div class="d-flex justify-content-center">
                                <small class="my-2">
                                    Please enter your email address to search for your account.
                                </small>
                            </div>

                            <form action="{{ route('send_reset_link') }}" method="POST" autocomplete="off" class="mt-3">
                                @csrf
                                <div class="row p-0">
                                    <div class="form-group col-md-8 offset-md-2">
                                        <input type="email" name="email"
                                            class="form-control mb-2 @error('email') is-invalid @enderror "
                                            placeholder="Enter your email" autocomplete="off">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        @error('no_user')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        @error('no_rm')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="form-group col-md-8 offset-md-2">
                                        <button type="button" id="submit-btn" class="btn btn-primary btn-block">Send Reset
                                            Link</button>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center">
                                    <small><a href="{{ route('login') }}" class="btn btn-link">Go Back</a></small>
                                </div>
                            </form>


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
<script>
    // init
    $(document).ready(function() {

        $("#submit-btn").on('click', function() {
            $('#submit-btn').prop('disabled', true);
            $('form').submit();
        });

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
