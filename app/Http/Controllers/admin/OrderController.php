<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function incomplete()
    {

        $orders=DB::table('carts')->where('product_order','yes')
            ->groupBy('invoice_no')
            ->get();

        return view('admin.order.incomplete',compact('orders'));
    }
    public function complete()
    {

        $orders=DB::table('carts')->where('product_order','delivery')
            ->groupBy('invoice_no')
            ->get();

        return view('admin.order.complete',compact('orders'));
    }

    public function location()
    {
        return view('admin.order.location');
    }

    public function process()
    {
        $orders=DB::table('carts')->where('product_order','approve')
            ->groupBy('invoice_no')
            ->get();

        return view('admin.order.process',compact('orders'));
    }
    public function cancel()
    {
        $orders=DB::table('carts')->where('product_order','cancel')
            ->groupBy('invoice_no')
            ->get();

        return view('admin.order.cancel',compact('orders'));
    }

}
