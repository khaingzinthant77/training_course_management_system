<html>

<head>
</head>

<body>
    <table class="table table-bordered styled-table ">
        <thead>
            <tr>
                <th align="center" colspan="10">{{ $title }}</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Invoice ID</th>
                <th>Student Name</th>
                <th>Phone</th>
                <th>Payment Method</th>
                <th>Pay Date</th>
                <th>Course</th>
                <th>Fee</th>
                <th>Discount</th>
                <th>Netpay</th>
            </tr>

        </thead>

        <tbody>
            @php
                $totalNetPay = 0;
                $totalFee = 0;
                $totalDiscount = 0;
                $i = 0;
                
            @endphp
            @forelse ($invoices as $invoice)
                @php
                    $totalNetPay += $invoice->net_pay;
                    $totalFee += $invoice->course_fee;
                    $totalDiscount += $invoice->discount_amount;
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
                    <td style="text-align:right;">{{ number_format($invoice->course_fee) }}</td>
                    <td style="text-align:right;">{{ number_format($invoice->discount_amount) }}</td>
                    <td style="text-align:right;">{{ number_format($invoice->net_pay) }}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <td align="right" colspan="6">Total Net Pay: </td>
                <td align="right" colspan="1">{{ number_format($totalFee) }}</td>
                <td align="right" colspan="1">{{ number_format($totalDiscount) }}</td>
                <td align="right" colspan="1">{{ number_format($totalNetPay) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
