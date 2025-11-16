@extends('layout', ['title'=> 'Home'])

@section('page-content')
<div>
    <br>
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
<table id="cart" class="table table-hover table-condensed container">
    <thead>
        <tr>
            <th style="width:20%">Image</th>
            <th style="width:30%">Item</th>
            <th style="text-align:center;width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @foreach($carts as $product)
            @php $total += $product->price * $product->quantity @endphp
            <tr>
                <td> <img class="image" src="{{asset('assets/images/'.$product->image)}}" alt=""> </td>
                <td>{{$product->name}}<p>{{$product->description}}</p></td>
                <td style="text-align:center">{{$product->price}} Руб</td>
                <td style="text-align:center">{{$product->quantity}}</td>
                <td style="text-align:center">{{$product->subtotal}} Руб</td>
                <td style="text-align:right;" class="actions" data-th="">
                    <form method="post" action="{{route('cart.destroy', $product->id)}}" onsubmit="return confirm('Sure?')">
                        @csrf
                        <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash">
                        </i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    <tfoot>
    <tr @if($product->coupon_id) class="d-none" @endif>
        <form method="post" action="{{route('coupon/apply')}}">
            @csrf

            <td colspan="4" class="text-right" ><strong>  <p style="margin-top:8px !important;">Coupon Code</p> </strong></td>
            <td>  <input type="text" name="code" class="form-control" id="exampleFormControlInput1" placeholder=""></td>
            <td> <button type="submit" class="btn btn-dark" @if($total_price==0) disabled @endif>Apply</button> </td>

        </form>
        </tr>
    @if($total_price!=0)
        @foreach($extra_charge as $chrage)
            <tr>
                <td colspan="4"></td>
                <td class="text-right">{{  $chrage->name }}</td>
                <td class="text-right">{{  $chrage->price }} Руб</td>
            </tr>
        @endforeach
    @endif

        @php


        $total = $total_price + $total_extra_charge;

        Session::put('total',$total_price);

        if($total_price!=0)
        {
            $total_price=$total_price+$total_extra_charge;
            $without_discount_price=$without_discount_price + $total_extra_charge;

        }
        @endphp
       <tr>
            <td colspan="4"></td>
            <td class="text-right">Total</td>
            <td class="text-right">{{  $without_discount_price }} Руб</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td class="text-right">Discount</td>
            <td class="text-right">{{  $discount_price }} Руб</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td class="text-right">Total (With Discount)</td>
            <td class="text-right">{{  $total_price }} Руб</td>
        </tr>

        <tr >
            <td colspan="6" class="text-right">
                <a href="{{ url('/menu') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>

                    @csrf
                    @if($total_price==0)
                    <button class="btn btn-success" disabled>Checkout</button>
                    @else
                        <a href="{{route('cart.checkout')}}"><button class="btn btn-success">Checkout</button></a>
                    @endif

            </td>
        </tr>
    </tfoot>
</table>
</div>
@endsection


