<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    public function index()
    {

        $coupons=DB::table('coupons')->paginate(10);


        return view('admin.coupon.index',compact('coupons'));

    }


    public function add()
    {

        return view('admin.coupon.add');

    }

    public function create(Request $req)
    {

        $data=array();

        $data['name']=$req->name;
        $data['details']=$req->details;
        $data['percentage']=$req->discount_percentage;
        $data['code']=$req->code;
        $data['validate']=$req->vaildation_date;



        $percentage=$req->discount_percentage;

        if($percentage < 0)
        {

            session()->flash('wrong','Negative percentage do not accepted !');
            back();



        }


        $code=DB::table('coupons')->where('code',$req->code)->count();


        if($code > 0)
        {

            session()->flash('wrong','Code already exits !');
            return back();


        }


        $load=DB::table('coupons')->Insert($data);



        session()->flash('success','Coupon added successfully !');

        return back();

    }

    public function delete($id)
    {
        $delete=DB::table('coupons')->where('id',$id)->delete();

        session()->flash('success','Coupon deleted successfully !');

        return back();
    }

    public function edit($id)
    {
        $coupon=DB::table('coupons')->where('id',$id)->get();
        return view('admin.coupon.edit',compact('coupon'));
    }

    public function update(Request $req, $id)
    {

        $data=array();

        $data['name']=$req->name;
        $data['details']=$req->details;
        $data['percentage']=$req->discount_percentage;
        $data['code']=$req->code;
        $data['validate']=$req->vaildation_date;



        $percentage=$req->discount_percentage;

        if($percentage < 0)
        {

            session()->flash('wrong','Negative percentage do not accepted !');
            return back();



        }


        $code=DB::table('coupons')->where('code',$req->code)->where('id','!=',$id)->count();


        if($code > 0)
        {

            session()->flash('wrong','Code already exits !');
            return back();


        }





        $load=DB::table('coupons')->where('id',$id)->Update($data);



        session()->flash('success','Coupon updated successfully !');

        return back();


    }


}
