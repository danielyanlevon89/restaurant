<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->query('search');
        $orders=DB::table('carts')
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'like', "%$search%");
            })
            ->where('product_order','!=','no')
            ->groupBy('invoice_no')
            ->orderBy('purchase_date','desc')
            ->orderBy('delivery_date', 'asc')
            ->paginate(10)
        ;

        return view('admin.order.search',compact('orders'));
    }

    public function incomplete()
    {

        $orders=DB::table('carts')
            ->where('product_order','yes')
            ->groupBy('invoice_no')
            ->orderBy('purchase_date','desc')
            ->orderBy('delivery_date', 'asc')
            ->paginate(10)
            ;

        return view('admin.order.incomplete',compact('orders'));
    }
    public function complete()
    {

        $orders=DB::table('carts')
            ->where('product_order','delivery')
            ->groupBy('invoice_no')
            ->orderBy('purchase_date','desc')
            ->orderBy('delivery_date', 'asc')
            ->paginate(10);

        return view('admin.order.complete',compact('orders'));
    }


    public function process()
    {
        $orders=DB::table('carts')
            ->where('product_order','approve')
            ->groupBy('invoice_no')
            ->orderBy('purchase_date','desc')
            ->orderBy('delivery_date', 'asc')
            ->paginate(10);

        return view('admin.order.process',compact('orders'));
    }
    public function cancel()
    {
        $orders=DB::table('carts')->where('product_order','cancel')
            ->groupBy('invoice_no')
            ->orderBy('purchase_date','desc')
            ->orderBy('delivery_date', 'asc')
            ->paginate(10);

        return view('admin.order.cancel',compact('orders'));
    }

}
