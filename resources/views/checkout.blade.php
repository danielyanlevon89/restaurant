@extends('layout', ['title'=> 'Home'])

@section('page-content')
<div style="width:80%; margin:auto;">
    <br>
    <br>
    <br>
    <br>
    <h1>Your order amount is {{$total_price}} Руб</h1><br>
    <h2 style="color:#FB5849">Choose a payment method</h2><br>

    <div ng-switch="myVar">
        @if (Auth::check())
            <div ng-switch-when="cod" style="float:left;margin-right: 10px">

                <form style="display:inline"  method="post" action="{{route('shipment')}}">
                @csrf
                    <img style="max-width:150px;" src="{{ asset('assets/images/cod.png')}}">
                    <br>
                    <br>
                    <input class="btn btn-success" type="submit" value="Place Order">
                </form>
            </div>
            <div ng-switch-when="bkash">
            <?php
                Session::put('total',$total_price);
            ?>
                <img style="max-width:150px;"  src="{{ asset('assets/images/bkash.png')}}">
                <br>
                <br>

            <a href="/ssl/pay"><input class="btn btn-success" type="submit" value="Pay with Online"></a>

{{--                @include('bkash-script')--}}
            </div>
        @else
            <div ng-switch-when="cod">

            </div>
            <div ng-switch-when="bkash">
                <a href="/login"><input class="btn btn-success" type="submit" value="Log in"></a>
            </div>
        @endif
    </div>
</form>
</div>
@endsection
