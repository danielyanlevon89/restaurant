@extends('admin.adminlayout')

@section('container')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search Result</h4>
                    <p class="card-title">Search String: <b>{{ request()->get('search')  }}</b></p>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th> Create Date</th>
                                <th> Invoice No</th>
                                <th> Customer Name</th>
                                <th> Customer Phone</th>
                                <th> Room Number</th>
                                <th> Payment Method</th>
                                <th> Order Status</th>
                                <th> Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $order)
                                <tr>

                                    <td>
                                        <span class="ps-2">{{ $order->purchase_date }}</span>
                                    </td>
                                    <td> {{ $order->invoice_no }} </td>
                                    <td>


                                        @php

                                            $user=DB::table('users')->where('id',$order->user_id)->first();

                                        @endphp


                                        {{  $user->name??'' }}


                                    </td>


                                    <td>  {{  $user->phone??'' }}</td>
                                    <td> {{ $order->room_number }} </td>

                                    <td> {{ $order->pay_method }} </td>

                                    <td> @switch($order->product_order)
                                            @case('yes')
                                                <span class="text-warning">Pending</span>
                                                @break

                                            @case('delivery')
                                                <span class="text-success">Complete</span>
                                                @break

                                            @case('approve')
                                                <span class="text-info">Processing</span>
                                                @break

                                            @default
                                                <span class="text-danger">Cancelled</span>
                                        @endswitch </td>

                                    <td>

                                        <a href="{{route('admin.invoice.details', ['id' => $order->invoice_no])}}"
                                           class="badge badge-outline-primary">Details</a>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>


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

            .closebtn:hover {
                color: black;
            }
        </style>
