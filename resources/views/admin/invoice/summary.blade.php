@extends('layouts.master')

@section('content')
    <style>
        #header {
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css">
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">

            {{-- <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">INVOICE SUMMARY</span>
                </div>
            </div> --}}

            <div class="my-2 d-flex justify-content-between">
                @php
                    $from_date = $_GET['from_date'] ?? '';
                    $to_date = $_GET['to_date'] ?? '';
                @endphp
            </div>

            <div class="mb-3">
                <div id="header" class="text-primary mb-3">INVOICE SUMMARY</div>

                <div class="mb-2">
                    <form action="" id="my-form">
                        <div class="row justify-content-start">
                            <div class="col-lg-3 col-sm-6">
                                <label for="startDate">Start</label>
                                <input id="startDate" name="from_date" class="form-control" type="date"
                                    value="{{ $from_date }}" />
                                <span id="startDateSelected"></span>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label for="endDate">End</label>
                                <input id="endDate" name="to_date" class="form-control" type="date"
                                    value="{{ $to_date }}" />
                                <span id="endDateSelected"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="app-theme text-light">
                        <tr>
                            <th>Course</th>
                            <th>Fee</th>
                            <th>Discount</th>
                            <th>Netpay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalFee = 0;
                            $totalDiscount = 0;
                            $totalNetpay = 0;
                        @endphp
                        @forelse ($invoices as $invoice)
                            @php
                                $totalFee += $invoice->total_fee;
                                $totalDiscount += $invoice->total_discount;
                                $totalNetpay += $invoice->total_netpay;
                            @endphp
                            <tr>
                                <td>{{ $invoice->name }}</td>
                                <td>{{ number_format($invoice->total_fee) }}</td>
                                <td>{{ number_format($invoice->total_discount) }}</td>
                                <td>{{ number_format($invoice->total_netpay) }}</td>
                            </tr>
                        @empty
                        @endforelse
                        <tr>
                            <td align="right">All Total :</td>
                            <td>{{ number_format($totalFee) }}</td>
                            <td>{{ number_format($totalDiscount) }}</td>
                            <td>{{ number_format($totalNetpay) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {


            $('.select2').select2({
                theme: 'bootstrap-5',
            });


            $(".flatpickr").flatpickr({
                dateFormat: "d-m-Y",
            });

            $(".datepicker").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });

            $('#endDate').on('change', function() {
                let val = $('#startDate').val();
                if (val) {
                    $('#my-form').submit();
                }
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
        });
    </script>
@endsection
