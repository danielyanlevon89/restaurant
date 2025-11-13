<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index()
    {

        $banners=DB::table('banners')->get();


        return view('admin.banner.index',compact('banners'));


    }


    public function add()
    {

        return view('admin.banner.add');

    }

    public function create(Request $req)
    {

        $data=array();

        $this->validate(request(),[

            'image'=>'mimes:jpeg,jpg,png',
        ]);


        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);
        $data['image']=$new_image;


        $upload=DB::table('banners')->Insert($data);

        session()->flash('success','Banner added successfully !');

        return back();

    }

    public function delete($id)
    {
        $delete=DB::table('banners')->where('id',$id)->delete();

        session()->flash('success','Banner deleted successfully !');

        return back();
    }

    public function edit($id)
    {
        $banner=DB::table('banners')->where('id',$id)->get();
        return view('admin.banner.edit',compact('banner'));
    }

    public function update(Request $req, $id)
    {

        $data=array();

        $this->validate(request(),[

            'image'=>'mimes:jpeg,jpg,png',
        ]);


        $uploadedfile=$req->file('image');
        $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
        $uploadedfile->move(public_path('/assets/images/'),$new_image);
        $data['image']=$new_image;


        $update=DB::table('banners')->where('id',$id)->Update($data);

        session()->flash('success','Banner  updated successfully !');

        return back();


    }


}
