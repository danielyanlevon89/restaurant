<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function reservation()
    {
        $reservations=DB::table('reservations')->get();

        return view('admin.reservation.index',compact('reservations'));

    }


}
