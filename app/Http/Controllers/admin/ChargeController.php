<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class ChargeController extends Controller
{

    public function index()
    {

        $charges=DB::table('charges')->get();


        return view('admin.charge.index',compact('charges'));


    }


    public function add()
    {

        return view('admin.charge.add');

    }

    public function create(Request $req)
    {

        $data=array();

        $data['name']=$req->name;
        $data['price']=$req->price;




        $price=$req->price;

        if($price < 0)
        {

            session()->flash('wrong','Negative price do not accepted !');
            return back();



        }


        $load=DB::table('charges')->Insert($data);



        session()->flash('success','Charge added successfully !');

        return back();

    }

    public function delete($id)
    {
        $delete=DB::table('charges')->where('id',$id)->delete();

        session()->flash('success','Charge deleted successfully !');

        return back();
    }

    public function edit($id)
    {


        $charge=DB::table('charges')->where('id',$id)->get();



        return view('admin.charge.edit',compact('charge'));


    }

    public function update(Request $req, $id)
    {

        $data=array();

        $data['name']=$req->name;
        $data['price']=$req->price;




        $price=$req->price;

        if($price < 0)
        {

            session()->flash('wrong','Negative price do not accepted !');
            return back();



        }


        $load=DB::table('charges')->where('id',$id)->Update($data);



        session()->flash('success','Charge updated successfully !');

        return back();


    }


}
