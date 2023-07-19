@extends('layouts.master')

@section('content')
    <style>
        .cus-border {
            border: 1px solid rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 5px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 2px;
            bottom: 0px;
            top: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 36px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="container-fluid">
        <form action="{{ route('setting.update', $setting->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card shadow mb-4 p-3">
                <div class="my-2 d-flex justify-content-between">
                    <div></div>
                    <div class="d-flex">
                        <button class="btn btn-sm btn-primary unicode mr-2" type="button" id="unlock-btn">
                            <i class="fas fa-unlock"></i> Unlock
                        </button>
                        <button class="btn btn-sm btn-danger unicode mr-2" type="button" id="lock-btn">
                            <i class="fas fa-lock"></i> Lock
                        </button>
                        <button class="btn btn-sm btn-success unicode" type="submit" id="update-btn">
                            <i class="fas fa-cog"></i> Update
                        </button>
                    </div>
                </div>

                {{-- General Setting Start --}}
                <h6 class="text-muted mt-4 font-weight-bold">General Setting</h6>
                <div class="cus-border">
                    <div class="row mb-4">
                        {{-- Login Retry Count --}}
                        <div class="col-md-4">
                            <label>Late Interval</label>
                            <input type="number" name="late_interval" value="{{ $setting->late_interval }}"
                                class="form-control">
                        </div>
                    </div>
                </div>
                {{-- General Setting End --}}

                {{-- Mail Setting Start --}}
                <h6 class="text-muted mt-4 font-weight-bold">Mail Setting</h6>
                <div class="cus-border">
                    <div class="row mb-4">

                        {{-- Mail Username --}}
                        <div class="col-md-4">
                            <label>Mail Address</label>
                            <input type="text" name="mail_username" value="{{ $setting->mail_username }}"
                                class="form-control">
                        </div>

                        {{-- Mail Password --}}
                        <div class="col-md-4">
                            <label>Mail App Password</label>
                            <input type="text" name="mail_password" value="{{ $setting->mail_password }}"
                                class="form-control">
                        </div>

                        {{-- Mail Port --}}
                        <div class="col-md-4">
                            <label>Port</label>
                            <input type="number" name="mail_port" value="{{ $setting->mail_port }}" class="form-control">
                        </div>

                    </div>

                    <div class="row mb-4">

                        {{-- Mail Host --}}
                        <div class="col-md-4">
                            <label>Host</label>
                            <input type="text" name="mail_host" value="{{ $setting->mail_host }}" class="form-control">
                        </div>

                        {{-- Mail From Name  --}}
                        <div class="col-md-4">
                            <label>Sender Name</label>
                            <input type="text" name="mail_from_name" value="{{ $setting->mail_from_name }}"
                                class="form-control">
                        </div>

                        {{-- Mail From Address --}}
                        <div class="col-md-4">
                            <label>From Address</label>
                            <input type="text" name="mail_from_address" value="{{ $setting->mail_from_address }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="row mb-4">
                        {{-- Mail Encryption --}}
                        <div class="col-md-4">
                            <label>Encryption</label>
                            <input type="text" name="mail_encryption" value="{{ $setting->mail_encryption }}"
                                class="form-control">
                        </div>

                        {{-- Recovery Mail --}}
                        <div class="col-md-4">
                            <label>Recovery Mail</label>
                            <input type="text" name="recovery_mail" value="{{ $setting->recovery_mail }}"
                                class="form-control">
                        </div>

                        {{-- Password Reset Expire --}}
                        <div class="col-md-4">
                            <label>Reset Password Expire</label>
                            <input type="text" name="pwd_reset_expire" value="{{ $setting->pwd_reset_expire }}"
                                class="form-control">
                        </div>
                    </div>

                </div>
                {{-- Mail Setting End --}}
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            let timerInterval

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: 'Success',
                    icon: 'success',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // console.log('I was closed by the timer')
                    }
                })
            @endif

            // Error Alert
            @if (Session::has('error'))
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // console.log('I was closed by the timer')
                    }
                })
            @endif

            // init settings
            $("#update-btn").attr("disabled", true);
            $(".form-control").attr("disabled", true);
            $("#lock-btn").hide();


            // unlock btn click
            $("#unlock-btn").on("click", function() {
                $("#lock-btn").show();
                $("#unlock-btn").hide();
                $('.form-control').prop('disabled', false);
                $("#update-btn").attr("disabled", false);
            });

            // lock btn click
            $("#lock-btn").on("click", function() {
                $("#lock-btn").hide();
                $("#unlock-btn").show();
                $('.form-control').prop('disabled', true);
                $("#update-btn").attr("disabled", true);
            });
        });
    </script>
@endsection
