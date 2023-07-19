@extends('layouts.master')

@section('content')
    <style>
        /* .wrapper {
                                                            width: 100vw;
                                                            height: 100vh;
                                                        } */

        .logo {
            width: 10rem;
        }

        nav {
            padding: 0.5rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            border-bottom: 2px solid rgba(0, 0, 0, 0.35);
        }

        .banner {
            display: flex;
            justify-content: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.25);
        }

        nav p {
            font-size: 12px;
            opacity: 0.8;
        }

        .banner p {
            font-size: 8px;
            opacity: 0.8;
        }

        #official {
            margin-top: 0.25rem;
            font-size: 1.35rem;
            font-weight: bold;
            color: #2350A2;
            text-align: center;
        }

        table {
            width: 100%;
        }

        .table-container {
            margin-top: 1rem;
            display: flex;
        }

        .table-container table tr td {
            padding: 0.5rem;
            font-size: 12px;
        }

        #voucher-table tr td,
        #voucher-table th {
            font-size: 12px;
        }


        #voucher-table tr,
        #voucher-table td {
            border: 1px solid #2350A2;
            padding: 0.5rem;
        }


        #voucher-table {
            border-collapse: collapse;
        }

        .sign {
            position: absolute;
            padding: 0.5rem 0;
            display: inline;
            font-size: 12px;
            border-top: 1px dotted rgba(0, 0, 0, 0.5);
            bottom: 5%;
            right: 5%;
        }

        .text {
            font-size: 12px;
        }

        #address {
            width: 70%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: flex-end;
        }

        #address div {
            font-size: 10px;
        }
    </style>
    <div class="container-fluid">

        <div class="card shadow mb-4 p-3">

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <span class="text-primary">INVOICE DETAIL</span>
                </div>
                <div>
                    <a href="{{ route('invoice.show', $invoice->id) }}" target="_blank" class="btn btn-sm btn-primary"><i
                            class="fa-solid fa-print"></i></a>
                </div>
            </div>

            <div id="invoice">
                <div class="wrapper">
                    {{-- <img id="backdrop" src="{{ asset('/images/linn.png') }}" alt=""> --}}
                    <nav>
                        <img class="logo" src="{{ asset('images/linnlogo.jpg') }}" alt="">
                        <div id="address">
                            <div> အမှတ် (၁၄ / ၅၈၅)၊ ပေါင်းလောင်း(၄)လမ်း ၊ ပျဥ်းမနားမြို့။</div>
                            <div style="margin-bottom: 0.25rem;">ဖုန်းနံပါတ်: 09-456100456, 09-788788778
                            </div>

                            {{-- <div>Linn 2: အမှတ် (၁၁၇) ၊ သပြေကုန်းရပ်ကွက်၊ နေပြည်တော်။</div>
                            <div>ဖုန်းနံပါတ်: 067-414884 , 414885 , 432884</div> --}}
                        </div>
                    </nav>
                    <div id="official">OFFICIAL RECEIVED</div>

                    <div style="padding:0 1rem; margin-top:1.5rem;">
                        <div style="display: flex; justify-content:space-between; margin:1rem 0">
                            <div style="display: flex; justify-content:space-between; width:30%;">
                                <div class="text">Name</div>
                                <div class="text">{{ $invoice->student_name }}</div>
                            </div>
                            <div style="display: flex; justify-content:space-between; width:35%;">
                                <div class="text">Invoice ID</div>
                                <div class="text">{{ $invoice->invoiceID }}</div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content:space-between; margin:1rem 0">
                            <div style="display: flex; justify-content:space-between; width:30%;">
                                <div class="text">Phone</div>
                                <div class="text">{{ $invoice->phone_1 }}</div>
                            </div>
                            <div style="display: flex; justify-content:space-between; width:35%;">
                                <div class="text">Date</div>
                                <div class="text">{{ date('d-m-Y', strtotime($invoice->created_at)) }}</div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:0 1rem; margin-top:1.5rem;">
                        <table id="voucher-table">
                            <thead style="background-color: #2350A2; color:#fff;">
                                <tr>
                                    <th>No.</th>
                                    <th>Course</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                    $course = getCourse($invoice->course_id);
                                @endphp
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ number_format($course->fee) }}</td>
                                    <td> {{ number_format($invoice->discount_amount) }}</td>
                                    <td align="right">{{ number_format($invoice->net_pay) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Remark : {{ $invoice->remark }}</td>
                                    <td>Total</td>
                                    <td align="right">{{ number_format($course->fee) }}</td>
                                </tr>
                                <tr style="border:none;">
                                    <td colspan="3" style="border:none;"></td>
                                    <td>Discount</td>
                                    <td align="right">{{ number_format($invoice->discount_amount) }}</td>
                                </tr>
                                <tr style="border:none;">
                                    <td colspan="3" style="border:none;"></td>
                                    <td>Net Amount</td>
                                    <td align="right">{{ number_format($invoice->net_pay) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="padding: 2rem 2rem">
                        <div class="sign">Authorized Signature</div>
                    </div>
                </div>
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

        });
    </script>
@endsection
