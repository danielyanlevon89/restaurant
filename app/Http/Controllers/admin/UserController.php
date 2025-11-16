<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {

        $users=DB::table('users')->paginate(10);


        return view('admin.user.index',compact('users'));


    }


    public function add()
    {

        return view('admin.user.add');

    }

    public function create(Request $req)
    {


        $email=DB::table('users')->where('email',$req->email)->count();


        if($email > 0)
        {

            session()->flash('wrong','Email already registered !');
            return back();


        }

        $phone=DB::table('users')->where('phone',$req->phone)->count();


        if($phone > 0)
        {

            session()->flash('wrong','Phone already registered !');
            return back();


        }
        if(strlen($req->password)<8)
        {

            session()->flash('wrong','Password lenght at least 8 words!');
            return back();



        }

        if($req->password!=$req->confirm_password)
        {


            session()->flash('wrong','Password do not match !');
            return back();


        }

        $this->validate(request(),[

            'image'=>'mimes:jpeg,jpg,png',
        ]);

        if ($req->hasFile('image')) {
            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'), $new_image);
        }
        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']=$req->type;
        $data['profile_photo_path']=$new_image??'';
        $data['password']=Hash::make($req->password);





        $insert=DB::table('users')->Insert($data);


        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Congrats ! User Created successfully !. Your Email ID - '.$req->email. ' & Password - '.$req->password,
        ];



//        \Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


        session()->flash('success','User added successfully !');
        return back();



    }

    public function delete($id)
    {


        $details = [
            'title' => 'Mail from RMS Admin',
            'body' => 'Sorry ! You have been fired from your job by RMS Admin Panel.So, your account is deleted by RMS Admin Panel.',
        ];



//        \Mail::to(Auth::user()->email)->send(new \App\Mail\UserAddedMail($details));

        $delete=DB::table('users')->where('id',$id)->delete();


        session()->flash('success','User deleted successfully !');
        return back();



    }

    public function edit($id)
    {
        $user=DB::table('users')->where('id',$id)->get();


        return view('admin.user.edit',compact('user'));
    }

    public function update(Request $req, $id)
    {
        $email=DB::table('users')->where('email',$req->email)->where('id','!=',$id)->count();


        if($email > 0)
        {

            session()->flash('wrong','Email already registered !');
            return back();


        }

        $phone=DB::table('users')->where('phone',$req->phone)->where('id','!=',$id)->count();


        if($phone > 0)
        {

            session()->flash('wrong','Phone already registered !');
            return back();


        }


        $data=array();
        $data['name']=$req->name;
        $data['email']=$req->email;
        $data['phone']=$req->phone;
        $data['usertype']=$req->type;


        if ($req->hasFile('image'))
        {

            $this->validate(request(),[

                'image'=>'mimes:jpeg,jpg,png',
            ]);


            $uploadedfile=$req->file('image');
            $new_image=rand().'.'.$uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/admin/'),$new_image);
            $data['profile_photo_path']=$new_image;


        }

        $update=DB::table('users')->where('id',$id)->Update($data);

            $details = [
                'title' => 'Mail from RMS Admin',
                'body' => 'Congrats ! User information is updated by RMS Admin Panel.',
            ];

//            \Mail::to($req->email)->send(new \App\Mail\UserAddedMail($details));


            session()->flash('success','User updated successfully !');

        return back();


    }


}
