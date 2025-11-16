<?php

namespace App\Http\Controllers;

use App\Services\TelegramNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Auth;
use PDF;
use QrCode;

use DB;
use Session;




class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::all();
        return view("cart", compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Cart::all();

        // Ship the order...

        Mail::to($request->user())->send(new OrderShipped($order));
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function my_order()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');

        }


        $carts = Cart::all()->where('user_id',Auth::user()->id)->where('product_order','!=','no');
        $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->sum('subtotal');
        return view("my_order", compact('carts','total_price'));



    }
    public function trace()
    {

        if(!Auth::user())
        {

            return redirect()->route('login');

        }


        $carts = Cart::all()->where('user_id',Auth::user()->id)->where('product_order','yes');
        $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->sum('subtotal');
        return view("trace", compact('carts','total_price'));



    }

    public function trace_confirm(Request $req)
    {

        if(!Auth::user())
        {

            return redirect()->route('login');

        }
        $carts = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->where('invoice_no',$req->invoice)->count();

        if($carts==0)
        {

            session()->flash('wrong','Invaild Invoice no !');
            return back();

        }

        if($req->phone!=Auth::user()->phone)
        {

            session()->flash('wrong','Wrong phone no !');
            return back();

        }


        $carts = Cart::all()->where('user_id',Auth::user()->id)->where('product_order','!=','no')->where('invoice_no',$req->invoice);
        $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->where('invoice_no',$req->invoice)->sum('subtotal');
        $carts_amount = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->where('invoice_no',$req->invoice)->count();
        $without_discount_price=$total_price;
        $discount_price=0;
        $coupon_code=NULL;

        if($carts_amount>0)
        {
            foreach($carts as $cart)
            {

                $coupon_code=$cart->coupon_id;



            }

         }

         if($coupon_code!=NULL)
         {


            $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->where('invoice_no',$req->invoice)->sum('subtotal');


            $coupon_code_price=DB::table('coupons')->where('code',$coupon_code)->value('percentage');

            $coupon_code_price=floor($coupon_code_price);

            $discount_price=(($total_price*$coupon_code_price)/100);
            $discount_price=floor($discount_price);


            $total_price = $total_price - $discount_price;



         }
         else
         {

            $total_price = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','!=','no')->where('invoice_no',$req->invoice)->sum('subtotal');


         }
         $extra_charge=DB::table('charges')->get();
         $total_extra_charge=DB::table('charges')->sum('price');

         $total_price=$total_price+$total_extra_charge;
         $without_discount_price=$without_discount_price+$total_extra_charge;

        return view("trace_confirm", compact('carts','total_price','extra_charge','discount_price','without_discount_price'));



    }


    public function coupon_apply(Request $req)
    {


        $coupon_code=DB::table('coupons')->where('code',$req->code)->count();

        if($coupon_code == 0)
        {

            session()->flash('wrong','Wrong Coupon Code !');
            return back();

        }
        $validate=DB::table('coupons')->where('code',$req->code)->value('validate');

        $today=date("Y-m-d");

        if($validate < $today)
        {

            session()->flash('wrong','Expire Validation Date !');
            return back();



        }

        $data=array();

        $data['coupon_id']=$req->code;

        $update_coupon=DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->update($data);

        if($update_coupon)
        {



           return redirect('/cart');

        }
        else
        {

            session()->flash('wrong','Already applied this code !');
            return back();


        }


    }

}
