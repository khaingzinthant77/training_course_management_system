<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.3.0/css/all.css">
    <style>
        @font-face {
            font-family: linnFont;
            src: url('{{ asset('fonts/Linn-Caracas.otf') }}');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 16px;
            font-family: linnFont;
        }

        .wrapper {
            width: 100vw;
            height: 100vh;
        }

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
            border: 1px solid #808080;
            padding: 0.5rem;
        }

        #backdrop {
            opacity: 0.15;
            user-select: none;
            position: absolute;
            width: 25rem;
            /* top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); */
            top: 20%;
            left: 10%;
            transform: rotate(-25deg);
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



        @page {
            size: A5;
            margin-left: 0px;
            margin-right: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
            margin: 0;
            -webkit-print-color-adjust: exact;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <img id="backdrop" src="{{ asset('/images/linn.png') }}" alt="">
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
                <thead style="color:#fff;">
                    <tr style="background-color: gray;">
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



    <script>
        window.print();
    </script>
</body>

</html>
