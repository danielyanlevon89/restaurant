@extends('layout', ['title'=> 'Home'])

@section('page-content')

    <div class="container">
        <div class="py-5 text-center">
            <h2>Checkout Process</h2>

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
        </div>
    <div class="py-5 text-center">
        <h2>Cafe</h2>


    </div>

    <div class="row">

        <div class="col-md-12 order-md-1">

            <form method="POST" action="{{ route('payment.checkout') }}" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                <h4 class="mb-3">Room Number</h4>
                <div class="mb-3">
                    <label for="room_number">Room Number</label>
                    <input type="number" min="0" class="form-control" id="room_number" name="room_number" placeholder=""
                            required>
                    <div class="invalid-feedback">
                        Please enter your room number.
                    </div>
                </div>


                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Payment</span>
                </h4>
                <ul class="list-group mb-3">

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $total }} Руб</strong>
                    </li>
                </ul>

                <hr class="mb-4">

                <button type="submit" class="btn btn-primary btn-lg btn-block">Pay with Yandex Pay</button>

            </form>
        </div>
    </div>



</div>

@endsection
