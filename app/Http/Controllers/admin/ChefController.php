<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class ChefController extends Controller
{

    public function index()
    {

        $total_chefs = DB::table('chefs')->count();

        $fraction = $total_chefs % 3;

        $chefs = DB::table('chefs')->get();


        $fraction_chefs = DB::table('chefs')->latest()->get();


        return view('admin.chef.index', compact('chefs', 'fraction', 'total_chefs', 'fraction_chefs'));


    }


    public function add()
    {

        return view('admin.chef.add');

    }

    public function create(Request $req)
    {

        $this->validate($req, [
            'image' => 'mimes:jpeg,jpg,png,webp',
        ]);


        if ($req->hasFile('image')) {
            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'), $new_image);
        }

        $data = array();
        $data['name'] = $req->name;
        $data['job_title'] = $req->job;
        $data['facebook_link'] = $req->fb;
        $data['twitter_link'] = $req->twitter;
        $data['instragram_link'] = $req->instagram;
        $data['image'] = $new_image ?? '';


        $insert = DB::table('chefs')->Insert($data);
        return redirect()->route('admin.chefs')->with('success', 'Chef created successfully!');

    }

    public function delete($id)
    {
        $delete = DB::table('chefs')->where('id', $id)->delete();
        return redirect()->route('admin.chefs')->with('success', 'Chef deleted successfully !');
    }

    public function edit($id)
    {


        $chefs = DB::table('chefs')->where('id', $id)->get();


        return view('admin.chef.edit', compact('chefs'));


    }

    public function update(Request $req, $id)
    {

        $data = array();
        $data['name'] = $req->name;
        $data['job_title'] = $req->job;
        $data['facebook_link'] = $req->fb;
        $data['twitter_link'] = $req->twitter;
        $data['instragram_link'] = $req->instagram;

        if ($req->image != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png,webp',
            ]);


            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'), $new_image);

            $data['image'] = $new_image;

        }


        $update = DB::table('chefs')->where('id', $id)->Update($data);


        return redirect()->route('admin.chefs')->with('success', 'Chef updated successfully!');


    }


}
