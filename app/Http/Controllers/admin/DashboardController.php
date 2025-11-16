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

        $pending_order = DB::table('carts')->where('product_order', 'yes')->groupBy('invoice_no')->get()->count();

        $processing_order = DB::table('carts')->where('product_order', 'approve')->groupBy('invoice_no')->get()->count();

        $cancel_order = DB::table('carts')->where('product_order', 'cancel')->groupBy('invoice_no')->get()->count();

        $complete_order = DB::table('carts')->where('product_order', 'delivery')->groupBy('invoice_no')->get()->count();

        $total = DB::table('carts')->sum('subtotal');

        $cash_on_payment = DB::table('carts')->where('pay_method', 'Cash On Delivery')->sum('subtotal');

        $online_payment = $total - $cash_on_payment;

        $customer = DB::table('users')->where('usertype', '0')->count();
        $admin = DB::table('users')->where('usertype', '1')->count();

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

        $product_cart = DB::table('carts')
            ->select(
                DB::raw('ANY_VALUE(products.image) as image'),
                DB::raw('ANY_VALUE(carts.product_id) as product_id'),
                DB::raw('ANY_VALUE(carts.name) as product_name'),
                DB::raw('ANY_VALUE(carts.price) as product_price'),
                DB::raw('SUM(carts.quantity) as total_sold')
            )
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('product_order', '!=', 'no')
            ->where('product_order', '!=', 'cancel')
            ->groupBy('product_id')->orderBy('total_sold','desc')
            ->take(5)->get();

        return view('admin.dashboard', compact('pending_order', 'product_cart', 'total', 'copy_product', 'per_rate', 'product', 'cash_on_payment', 'online_payment', 'customer', 'admin', 'processing_order', 'cancel_order', 'complete_order'));
    }

}
