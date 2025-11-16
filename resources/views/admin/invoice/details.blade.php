@extends('admin.adminlayout')

@section('container')

    <br>

    @if(Session::has('wrong'))

        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Opps !</strong> {{Session::get('wrong')}}
        </div>
        <br>
    @endif
    @if(Session::has('success'))

        <div class="success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>Congrats !</strong> {{Session::get('success')}}
        </div>
        <br>
    @endif


    @foreach($products as $product)

        <div class="card">
            <h5 class="card-header">Customer Details</h5>
            <div class="card-body">
                  <?php
                    $user = DB::table('users')->where('id', $product->user_id)->first();
                 ?>
                <p class="card-text">Customer Name : <b>{{ $user->name??'' }}</b></p>
                <p class="card-text">Customer Phone : <b>{{ $user->phone??'' }}</b></p>
                <p class="card-text">Customer Email : <b>{{ $user->email??'' }}</b></p>
                <p class="card-text">Room Number : <b>{{ $product->room_number }}</b></p>
                <a href="{{ isset($user->id) ? route('admin.user.edit', ['id' => $user->id]) : '#'}}" class="btn btn-primary"><b>Details</b></a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Order Details</h5>
            <div class="card-body">
                <p class="card-text">Invoice No : <b>{{  $product->invoice_no }}</b></p>
                <p class="card-text">Delivery Date : <b>{{ $product->delivery_date??'' }}</b></p>
                <p class="card-text">Payment Method : <b>{{ $product->pay_method??'' }}</b></p>
            </div>
        </div>
        @break;

    @endforeach
    <br>
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order Items</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>


                                <th> Product Name</th>
                                <th> Price</th>
                                <th> Quantity</th>
                                <th> Subtotal</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($products as $product)
                                <tr>


                                    <td> {{ $product->name }} </td>
                                    <td> {{ $product->price }} </td>
                                    <td>


                                        {{ $product->quantity }}


                                    </td>


                                    <td>  {{  $product->subtotal }}</td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        @foreach($products as $product)
            @if($product->product_order=="yes")
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order Process</h4>
                            <table class="table table-left">
                                <tbody>
                                @foreach($extra_charge as $charge)
                                    <tr>
                                        <td> {{ $charge->name }} </td>
                                        <td>  {{  $charge->price }}</td>
                                    </tr>

                                @endforeach


                                <tr>
                                    <td>Total</td>
                                    <td class="">  {{  $wihout_discount_price }} Руб</td>
                                </tr>

                                <tr>
                                    <td>Discount</td>
                                    <td class="">  {{  $discount_price }} Руб</td>
                                </tr>

                                <tr>
                                    <td><h3>Total (With Discount)</h3></td>
                                    <td class=""><h3>  {{  $total_price }} Руб</h3></td>
                                </tr>


                                </tbody>
                            </table>

                            <form class="forms-sample" action="{{route('admin.invoice.approve', ['id' => $product->invoice_no])}}"
                                  method="post" enctype="multipart/form-data">

                                @csrf

                                <button type="submit" class="btn btn-primary me-2">Approve Order</button>
                                <a href="{{route('admin.invoice.cancel', ['id' => $product->invoice_no])}}"
                                   class="btn btn-danger">Cancel Order</a>
                            </form>

                            @break;


                        </div>
                    </div>

                </div>

            @endif
        @endforeach







        @endsection()


        <style>
            .alert {
                padding: 20px;
                background-color: #f44336;
                color: white;
            }
            .success {
                padding: 20px;
                background-color: #4BB543;
                color: white;
            }

            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }
            .table-left{
                text-align: left;
                width: 30% !important;
            }
            .closebtn:hover {
                color: black;
            }
        </style>
