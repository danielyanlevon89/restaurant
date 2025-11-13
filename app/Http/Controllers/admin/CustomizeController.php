<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class CustomizeController extends Controller
{

    public function edit()
    {

        $customize=DB::table('about_us')->get();

        return view('admin.customize.edit',compact('customize'));

    }
    public function save(Request $req)
    {

        $data=array();


        $data['title']=$req->title;
        $data['description']=$req->description;
        $data['youtube_link']=$req->youtube_video_link;


        if($req->image != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image);
            $data['iamge1']=$new_image;


        }

        if($req->image2 != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile=$req->file('image');
            $new_image2=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image2);
            $data['iamge2']=$new_image2;


        }

        if($req->image3 != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile=$req->file('image');
            $new_image3=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image3);
            $data['iamge3']=$new_image3;


        }

        if($req->image4 != NULL)
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile=$req->file('image');
            $new_image4=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'),$new_image4);
            $data['vd_image']=$new_image4;


        }
        $load=DB::table('about_us')->Update($data);

        session()->flash('success','Customize updated successfully !');

        return back();

    }

}
