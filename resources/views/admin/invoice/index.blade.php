@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">INVOICE</span>
                </div>
            </div>

            <div class="my-2 d-flex justify-content-between">
                @php
                    $keyword = $_GET['keyword'] ?? '';
                    $from_date = $_GET['from_date'] ?? '';
                    $to_date = $_GET['to_date'] ?? '';
                    $payment = $_GET['payment'] ?? '';
                    $student_id = $_GET['student_id'] ?? '';
                    $course_id = $_GET['course'] ?? '';
                    $time_table_id = $_GET['time_table'] ?? '';
                @endphp
                <form action="" class="col-md-2 p-0">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search" name="keyword"
                            value="{{ $keyword }}" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#filterModal" type="button"><i
                                    class="fa-solid fa-filter"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div>
                    <button type="button" id="export-btn" class="btn btn-warning">Excel <i
                            class="fa-solid ml-2 fa-file-excel"></i></button>
                    <form action="{{ route('invoice.export') }}" id="excel-form" method="POST">
                        @csrf

                        <input type="hidden" name="keyword" value="{{ $keyword }}">
                        <input type="hidden" name="to_date" value="{{ $to_date }}">
                        <input type="hidden" name="from_date" value="{{ $from_date }}">
                        <input type="hidden" name="payment" value="{{ $payment }}">
                        <input type="hidden" name="course" value="{{ $course_id }}">
                        <input type="hidden" name="time_table" value="{{ $time_table_id }}">
                    </form>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">More Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="GET">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Payment Method</label>
                                        <select name="payment" id="" class="form-control">
                                            <option value="">--Select--</option>
                                            <option {{ $payment == 'cash' ? 'selected' : '' }} value="cash">Cash</option>
                                            <option {{ $payment == 'k-pay' ? 'selected' : '' }} value="k-pay">KPay</option>
                                            <option {{ $payment == 'wave-pay' ? 'selected' : '' }} value="wave-pay">Wave
                                                Pay
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Course</label>
                                        <select name="course" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse (courses() as $course)
                                                <option {{ $course_id == $course->id ? 'selected' : '' }}
                                                    value="{{ $course->id }}">{{ $course->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Section</label>
                                        <select name="time_table" id="" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse (timetables() as $time_table)
                                                <option {{ $time_table_id == $time_table->id ? 'selected' : '' }}
                                                    value="{{ $time_table->id }}">{{ $time_table->section }}
                                                    ({{ $time_table->duration }})
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" value="{{ $from_date }}"
                                            class="form-control flatpickr" autocomplete="off"
                                            placeholder="{{ date('d-m-Y') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" value="{{ $to_date }}"
                                            class="form-control flatpickr" autocomplete="off"
                                            placeholder="{{ date('d-m-Y') }}">
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

            <span class="text-primary">TOTAL INVOICE : {{ $count }}</span>
            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>#</th>
                            <th>Invoice ID</th>
                            <th>Student Name</th>
                            <th>Phone</th>
                            <th>Payment Method</th>
                            <th>Pay Date</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Fee</th>
                            <th>Discount</th>
                            <th>Netpay</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalNetPay = 0;
                            $totalFee = 0;
                            $totalDiscount = 0;
                            
                        @endphp
                        @forelse ($invoices as $invoice)
                            @php
                                $totalNetPay += $invoice->net_pay;
                                $totalFee += $invoice->course_fee;
                                $totalDiscount += $invoice->discount_amount;
                                $course_fee = $invoice->discount_amount + $invoice->net_pay;
                            @endphp
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $invoice->invoiceID }}</td>
                                <td>{{ $invoice->student_name }}</td>
                                <td>
                                    <div>{{ $invoice->phone_1 }}</div>
                                </td>
                                <td>{{ $invoice->payment_method }}</td>
                                <td>{{ date('d-m-Y', strtotime($invoice->created_at)) }}</td>
                                <td>{{ $invoice->course_name }}</td>
                                <td>
                                    <div>
                                        <div>{{ $invoice->section }}</div>
                                    </div>
                                    <small>{{ $invoice->duration }}</small>
                                </td>
                                <td style="text-align:right;">{{ number_format($invoice->course_fee) }}</td>
                                <td style="text-align:right;">{{ number_format($invoice->discount_amount) }}</td>
                                <td style="text-align:right;">{{ number_format($invoice->net_pay) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            <a href="{{ route('invoice.detail', $invoice->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fa-solid fa-eye"></i></a>
                                        </div>
                                        <div class="mr-1">
                                            <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                class="btn btn-sm btn-info"><i class="fa-solid fa-edit"></i></a>
                                        </div>
                                        <div class="mr-1">
                                            <a href="{{ route('invoice.show', $invoice->id) }}" target="_blank"
                                                class="btn btn-sm btn-primary"><i class="fa-solid fa-print"></i></a>
                                        </div>
                                        <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST"
                                            id="delete-form-{{ $invoice->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" data-id="{{ $invoice->id }}"
                                                id="delete-btn-{{ $invoice->id }}" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        <tr>
                            <td align="right" colspan="8">Total Net Pay: </td>
                            <td align="right" colspan="1">{{ number_format($totalFee) }}</td>
                            <td align="right" colspan="1">{{ number_format($totalDiscount) }}</td>
                            <td align="right" colspan="1">{{ number_format($totalNetPay) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                {!! $invoices->appends(request()->input())->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $("#export-btn").on('click', function() {
                $('#excel-form').submit();
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



            // delete btn
            let invoices = @json($invoices);


            invoices.data.forEach(data => {
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
