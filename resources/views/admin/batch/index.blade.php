@extends('layouts.master')

@section('content')
    <style>
        #mydob>.flatpickr-wrapper {
            width: 23rem;
        }
    </style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">Batch</span>
                </div>

                <div>
                    <a href="{{ route('batch.create') }}" class="btn btn-sm app-theme text-light"><i class="fas fa-plus"></i>
                        Create New</a>
                </div>
            </div>

            <div class="my-2">
                @php
                    $keyword = $_GET['keyword'] ?? '';
                    $start_date = $_GET['start_date'] ?? '';
                    $end_date = $_GET['end_date'] ?? '';
                    $status = $_GET['status'] ?? '';
                    $course_id = $_GET['course'] ?? '';
                    $cby = $_GET['cby'] ?? '';
                @endphp
                <form action="" class="col-md-2 p-0">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search" name="keyword"
                            value="{{ $keyword }}" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#filterModal" type="button"><i
                                    class="fa-solid fa-filter"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">More Filter...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Course</label>
                                        <select name="course" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse (courses() as $course)
                                                <option {{ $course_id == $course->id ? 'selected' : '' }}
                                                    value="{{ $course->id }}">{{ $course->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select name="status" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            <option {{ $status == '1' ? 'selected' : '' }} value="1">Ongoing
                                            </option>
                                            <option {{ $status == '0' ? 'selected' : '' }} value="0">Finished
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" value="{{ $start_date }}"
                                            class="form-control flatpickr" autocomplete="off" placeholder="Start Date">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" value="{{ $end_date }}"
                                            class="form-control flatpickr" autocomplete="off" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <span class="text-primary">TOTAL BATCH : {{ $count }}</span>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Student</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batches as $batch)
                            <td>{{ ++$i }}</td>
                            <td>{{ $batch->name }}</td>
                            <td>
                                <a href="{{ url('students?batch=' . $batch->id) }}">
                                    {{ getStudentCountByBatch($batch->id) }}
                                </a>
                                / {{ $batch->max_students }}
                            </td>
                            <td>{{ date('d-m-Y', strtotime($batch->start_date)) }}</td>
                            <td>
                                @if ($batch->end_date)
                                    {{ date('d-m-Y', strtotime($batch->end_date)) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($batch->status)
                                    <span class="badge badge-success badge-pill">Ongoing</span>
                                @else
                                    <span class="badge badge-primary badge-pill">Finished</span>
                                @endif
                            </td>
                            <td>{{ $batch->c_by }}</td>
                            <td>
                                <div class="d-flex">
                                    <div class="mr-1">
                                        <a href="{{ route('batch.show', $batch->id) }}" class="btn btn-sm btn-warning"><i
                                                class="fas fa-eye"></i></a>
                                    </div>
                                    <div class="mr-1">
                                        <a href="{{ route('batch.edit', $batch->id) }}"
                                            class="btn btn-sm app-theme text-light"><i class="fas fa-edit"></i></a>
                                    </div>
                                    @if ($batch->status == '1')
                                        <div>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#FinishModal">Finished</button>
                                        </div>
                                    @else
                                    <div>
                                        <form action="{{ route('batch.unfinish', $batch->id) }}" method="POST"
                                            id="unfinish-form-{{ $batch->id }}">
                                            @csrf
                                            @method('POST')
                                            <button type="button" class="btn btn-sm btn-primary" data-id="{{ $batch->id }}"
                                                id="delete-btn-{{ $batch->id }}">UnFinished</button>
                                        </form>
                                    </div>
                                    @endif


                                    <!-- Modal -->
                                    <div class="modal fade" id="FinishModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">End this
                                                        {{ $batch->name }}?</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('batch.end', $batch->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>End Date</label>
                                                            <input type="text" name="end_date"
                                                                value="{{ date('d-m-Y') }}"
                                                                class="form-control flatpickr" autocomplete="off"
                                                                placeholder="End Date">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Remark</label>
                                                            <textarea name="remark" id="" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Confirm </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {!! $batches->appends(request()->input())->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(".dob").flatpickr({
            dateFormat: "d-m-Y",
            static: true,
        });

        $(".dob").on("change", function() {
            let id = $(this).data('id');
            let dob = $(this).val();
            if (dob == '') {
                $(`#change_dob${id}`).val();
            } else {
                $(`#change_dob${id}`).val(dob);
            }


        });

        $(document).ready(function() {

            $('.modal').on('change', '#nrc_code', function() {
                var code_id = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "<?php echo route('nrc_state'); ?>",
                    method: 'POST',
                    dataType: 'html',
                    data: {
                        code_id: code_id,
                        _token: token
                    },
                    success: function(data) {
                        $("select[name='nrc_state']").html(data);
                    }
                });
            });

            $('.select2').select2({
                theme: 'bootstrap-5',
            });

            $(".flatpickr").flatpickr({
                dateFormat: "d-m-Y",
            });




            let timerInterval

            // Success Alert
            @if (Session::has('success'))
                Swal.fire({
                    title: '{{ Session::get('success') }}',
                    icon: 'success',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1500,
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
                    title: '{{ Session::get('error') }}',
                    icon: 'error',
                    html: 'autoclose in <b></b> milliseconds.',
                    timer: 1500,
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


            let batches = @json($batches);


            batches.data.forEach(data => {
                $(`#delete-btn-${data.id}`).on('click', function(e) {
                    let id = $(`#delete-btn-${data.id}`).attr('data-id');
                    // sweet alert
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to unfinish this?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, unfinish it!'
                    }).then((result) => {
                        if (result.value) {
                            $(`#unfinish-form-${id}`).submit();
                        }
                    })
                });
            });

        });
    </script>
@endsection
