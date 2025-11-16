@extends('layout', ['title'=> 'Home'])

@section('page-content')
<div style="width:40%; margin:0 auto;">
    @if(Session::has('wrong'))
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Opps !</strong> {{Session::get('wrong')}}
        </div>
    @endif
    @if(Session::has('success'))
        <br>
        <div class="success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Congrats !</strong> {{Session::get('success')}}
        </div>
        <br>
    @endif

    <form method="POST" action="{{url('payment')}}" class="needs-validation" novalidate>
        @csrf
    <div class="col-md-12 order-md-1">
        <h4 class="mb-3 text-center"><b>Delivery Details</b></h4>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="room_number">Room Number</label>
                    <input type="number" min="0" class="form-control  " name="room_number" id="room_number" placeholder=""
                           required>
                    <div class="invalid-feedback">
                        Please enter your room number.
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="date">Delivery Date</label>
                    <div class="input-group">
                        <input  name="delivery_date" id="date" type="text" class="form-control" value="{{ date('Y-m-d') }}">

                    </div>
                </div>

            </div>

        <h1 class="mb-4 mt-4">Your order amount is <b>{{$total_price}} Руб</b></h1>
        <h2 style="color:#FB5849" >Choose a payment method</h2><br>


        @if (Auth::check())
            <div class="row">
                <div class="mb-3 col-md-3 ">
                        <img style="max-width:150px;" src="{{ asset('assets/images/cod.png')}}">
                        <input class="btn btn-success mt-3 " type="submit" name="place_order" value="Place Order">
                </div>
                <div class="mb-3 col-md-3">
                    <img style="max-width:150px;"  src="{{ asset('assets/images/bkash.png')}}">
                    <input class="btn btn-success mt-3" type="submit" name="pay_online" value="Pay with Online">
                </div>
            </div>
        @else
            <div ng-switch-when="bkash">
                <a href="/login"><input class="btn btn-success" type="submit" value="Log in"></a>
            </div>
        @endif

    </div>



</form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: new Date(),
            autoclose: true,
            todayHighlight: true
        });
    })
</script>
@endsection
