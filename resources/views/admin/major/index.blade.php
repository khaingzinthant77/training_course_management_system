@extends('layouts.master')

@section('content')
    <style>
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

        <div class="card shadow mb-4 p-3">
            <span class="text-primary">Majors</span>
            <div class="d-flex my-2">
                @php
                    $keyword = $_GET['keyword'] ?? '';
                @endphp
                <form action="" autocomplete="off">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="keyword"
                            value="{{ $keyword }}">
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">TOTAL MAJOR : {{ $count }}</span>
                </div>
                <div>
                    <a href="{{ route('major.create') }}" class="btn btn-sm app-theme text-light"><i
                            class="fas fa-plus"></i> Create New</a>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Order No</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($majors as $key => $major)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $major->name }}</td>
                                <td>{{ $major->order_no }}</td>
                                <td>
                                    <label class="switch">
                                        <input data-id="{{ $major->id }}" data-size="small" class="toggle-class"
                                            type="checkbox" data-onstyle="success" data-offstyle="danger"
                                            data-toggle="toggle" data-on="Active" data-off="InActive"
                                            {{ $major->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>{{ date('d-m-Y', strtotime($major->created_at)) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            <a href="{{ route('major.edit', $major->id) }}"
                                                class="btn btn-sm app-theme text-light"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <form action="{{ route('major.destroy', $major->id) }}" method="POST"
                                            id="delete-form-{{ $major->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" data-id="{{ $major->id }}"
                                                id="delete-btn-{{ $major->id }}" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" align="center">There is no data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {!! $majors->appends(request()->input())->links() !!}
            </div>
        </div>
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

            // change status
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ url('major_change_status') }}",
                    data: {
                        'status': status,
                        'id': id
                    },
                    success: function(response) {
                        if (response.status) {

                            let timerInterval;
                            Swal.fire({
                                title: 'Success',
                                icon: 'success',
                                html: 'autoclose in <b></b> milliseconds.',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector(
                                        'b')
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
                            });
                        }
                    }
                });
            });

            // delete btn
            let majors = @json($majors);


            majors.data.forEach(data => {
                $(`#delete-btn-${data.id}`).on('click', function(e) {
                    let id = $(`#delete-btn-${data.id}`).attr('data-id');
                    // sweet alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            $(`#delete-form-${id}`).submit();
                        }
                    })
                });
            });

        });
    </script>
@endsection
