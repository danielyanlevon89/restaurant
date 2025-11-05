<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index()
    {

        $total_products = DB::table('products')->count();

        $fraction = $total_products % 3;

        $products = DB::table('products')->get();


        $fraction_products = DB::table('products')->latest()->get();


        return view('admin.menu.index', compact('products', 'fraction', 'total_products', 'fraction_products'));


    }


    public function add()
    {

        return view('admin.menu.add');

    }

    public function create(Request $req)
    {


        if (!$req->price || $req->price < 0) {

            session()->flash('wrong', 'Negative Price value do not accept !');
            return back();


        }


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
        $data['description'] = $req->description;
        $data['price'] = $req->price;
        $data['catagory'] = $req->catagory;
        $data['meal_type'] = $req->meal_type;
        $data['available'] = $req->available;
        $data['image'] = $new_image ?? '';

        $insert = DB::table('products')->Insert($data);
        return redirect()->route('admin.menus')->with('success', 'Item created successfully!');
    }

    public function delete($id)
    {
        $delete = DB::table('products')->where('id', $id)->delete();
        return redirect()->route('admin.menus')->with('success', 'Menu Item deleted successfully !');

    }

    public function edit($id)
    {

        $products = DB::table('products')->where('id', $id)->get();


        return view('admin.menu.edit', compact('products'));


    }

    public function update(Request $req, $id)
    {

        if (!$req->price || $req->price < 0) {
            session()->flash('wrong', 'Negative Price value do not accept !');
            return back();

        }

        $data = array();
        $data['name'] = $req->name;
        $data['description'] = $req->description;
        $data['price'] = $req->price;
        $data['catagory'] = $req->catagory;
        $data['meal_type'] = $req->meal_type;
        $data['available'] = $req->available;

        if ($req->image != NULL) {

            $this->validate(request(), [

                'image' => 'mimes:jpeg,jpg,png,webp',
            ]);


            $uploadedfile = $req->file('image');
            $new_image = rand() . '.' . $uploadedfile->getClientOriginalExtension();
            $uploadedfile->move(public_path('/assets/images/'), $new_image);

            $data['image'] = $new_image;

        }

        $update = DB::table('products')->where('id', $id)->Update($data);

        return redirect()->route('admin.menus')->with('success', 'Item updated successfully!');


    }


}
