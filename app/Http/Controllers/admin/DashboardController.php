<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;

class DashboardController extends Controller
{


    public function dashboard()
    {

        if (!Auth::user()) {

            return redirect()->route('login');


        }
        $usertype = Auth::user()->usertype;
        if ($usertype != '1') {
            return redirect('/');
        }

        $pending_order = DB::table('carts')->where('product_order', 'yes')->groupBy('invoice_no')->count();

        $processing_order = DB::table('carts')->where('product_order', 'approve')->groupBy('invoice_no')->count();

        $cancel_order = DB::table('carts')->where('product_order', 'cancel')->groupBy('invoice_no')->count();

        $complete_order = DB::table('carts')->where('product_order', 'delivery')->groupBy('invoice_no')->count();


        $total = DB::table('carts')->sum('subtotal');


        $cash_on_payment = DB::table('carts')->where('pay_method', 'Cash On Delivery')->sum('subtotal');


        $online_payment = $total - $cash_on_payment;


        $customer = DB::table('users')->where('usertype', '0')->count();


        $delivery_boy = DB::table('users')->where('usertype', '2')->count();


        $user = DB::table('users')->count();


        $admin = $user - ($customer + $delivery_boy);


        $rates = DB::table('rates')->get();

        $product = array();


        foreach ($rates as $rate) {


            $product[$rate->product_id] = 0;
            $voter[$rate->product_id] = 0;
            $per_rate[$rate->product_id] = 0;


        }


        foreach ($rates as $rate) {


            $product[$rate->product_id] = $product[$rate->product_id] + $rate->star_value;


            $voter[$rate->product_id] = $voter[$rate->product_id] + 1;

            if ($voter[$rate->product_id] > 0) {

                $per_rate[$rate->product_id] = $product[$rate->product_id] / $voter[$rate->product_id];

            } else {


                $per_rate[$rate->product_id] = $product[$rate->product_id];


            }

            $per_rate[$rate->product_id] = number_format($per_rate[$rate->product_id], 1);


        }

        $copy_product = $per_rate;

        arsort($per_rate);


        // return $per_rate;


        $product_get = array();


        foreach ($per_rate as $prod) {

            $index_search = array_search($prod, $copy_product);

            $product_get = DB::table('products')->where('id', $index_search)->get();


            // return $product_get;


        }


        $carts = DB::table('carts')->where('product_order', '!=', 'no')->where('product_order', '!=', 'cancel')->get();

        $cart = array();


        foreach ($carts as $cart) {


            $product_cart[$cart->product_id] = 0;


        }


        foreach ($carts as $cart) {


            $product_cart[$cart->product_id] = $product_cart[$cart->product_id] + $cart->quantity;


        }

        $copy_cart = $product_cart;

        arsort($product_cart);


        return view('admin.dashboard', compact('pending_order', 'product_cart', 'copy_cart', 'total', 'copy_product', 'per_rate', 'product', 'cash_on_payment', 'online_payment', 'customer', 'delivery_boy', 'admin', 'processing_order', 'cancel_order', 'complete_order'));


    }


}
