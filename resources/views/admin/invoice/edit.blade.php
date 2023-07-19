@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="card shadow mb-4 p-5">

            {{-- Create  --}}
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Invoice Update</h1>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('invoice.update',$invoice->id) }}" method="POST" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Course Fee</label>
                        <?php 
                            $original_amt = $invoice->discount_amount + $invoice->net_pay;
                         ?>
                        <input type="text" name="course_fee" id="course_fee"
                            class="form-control @error('course_fee') is-invalid @enderror" value="{{ old('course_fee',$original_amt) }}" readonly>
                        @error('course_fee')
                            <div class="text-danger font-weight-bold">* {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Discount Type</label>
                            <select class="form-control" id="discount" 
                                name="discount">
                                <option value="">None</option>
                                <option value="percentage">Percentage</option>
                                <option value="amount">Amount</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Discount Amount</label>
                            <input type="number" id="discount_amount" 
                                class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Net Amount</label>
                        <input type="text" name="net_amount" id="net_amount"
                            class="form-control @error('net_amount') is-invalid @enderror" value="{{ old('net_amount',$original_amt) }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" id="" class="form-control"
                            required>
                            <option value="">--Select--</option>
                            <option value="cash" {{$invoice->payment_method == 'cash' ? 'selected' : ''}}>Cash</option>
                            <option value="k-pay" {{$invoice->payment_method == 'k-pay' ? 'selected' : ''}}>KPay</option>
                            <option value="wave-pay" {{$invoice->payment_method == 'wave-pay' ? 'selected' : ''}}>Wave Pay</option>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                       <label for="name">Updated By</label> 
                       <select class="form-control" id="updated_by" name="updated_by">
                        @foreach(users() as $user)
                           <option value="{{$user->name}}" {{$user->name == auth()->user()->name ? 'selected' : ''}}>{{$user->name}}</option>
                           @endforeach
                       </select>
                    </div> -->

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('invoice.index') }}" class="btn btn-outline-primary btn-user btn-block">Go
                                Back</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-user btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(`#discount_amount`).on("input", function() {
                if ($(`#course_fee`).val() == '' || $(`#discount`).val() == "") {
                    return;
                }

                let course_fee = $(`#course_fee`).val();
                let discount_type = $(`#discount`).val();
                let discount_amount = this.value;

                if (discount_type == "percentage") {
                    let net = course_fee * (discount_amount / 100);
                    let result = course_fee - net;

                    if (Math.sign(result) === -1) {
                        $(`#net_amount`).val(0);
                    } else {
                        $(`#net_amount`).val(result);
                    }
                }

                if (discount_type == "amount") {
                    let net = course_fee - discount_amount;


                    if (Math.sign(net) === -1) {
                        $(`#net_amount`).val(0);
                    } else {
                        $(`#net_amount`).val(net);
                    }
                }
            });

            $(`#discount`).on("change", function() {
                $(`#discount_amount`).val('');
            });
        });
    </script>
@endsection
