@extends('layout', ['title'=> 'Home'])

@section('page-content')

<br><br><br><br>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

<table class="table table-striped table-bordered" style="margin:10%; max-width:80%;">
        @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{asset('assets/images/'.$product->image)}}" height=150px width=180px></td>
                    <td><h2>{{$product->name}}</h2>
                    <h4>{{$product->price}} Руб</h4>
                    <p>{{$product->description}}</p>
                    <form method="post" action="{{route('cart.store', $product)}}">
                        @csrf


                        <?php


                                $total_rate=DB::table('rates')->where('product_id',$product->id)
                                ->sum('star_value');


                                $total_voter=DB::table('rates')->where('product_id',$product->id)
                                ->count();

                                if($total_voter>0)
                                {

                                    $per_rate=$total_rate/$total_voter;

                                }
                                else
                                {

                                    $per_rate=0;


                                }

                                $per_rate=number_format($per_rate, 1);


                                $whole = floor($per_rate);      // 1
                                $fraction = $per_rate - $whole

                                ?>



                        <span class="product_rating">
                        @for($i=1;$i<=$whole;$i++)

                        <i class="fa fa-star "></i>

                        @endfor

                        @if($fraction!=0)

                        <i class="fa fa-star-half"></i>

                        @endif


                        <span class="rating_avg">({{  $per_rate}})</span>
            </span>

            <br>
            <br>

                        @if($product->available=="Stock")
                        <input type="number" name="number" style="width:50px;" id="myNumber" value="1">
                        <button class="btn btn-success">Add to Cart</button>
                        @endif
                        @if($product->available!="Stock") <p class="btn btn-danger">Out of Stock</p>
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
</table>
@endsection
