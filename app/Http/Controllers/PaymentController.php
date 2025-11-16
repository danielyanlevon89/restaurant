<?php

namespace App\Http\Controllers;

use App\Services\TelegramNotification;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Services\YooKassaService;
use Auth;
use DB;
class PaymentController extends Controller
{




    public function checkout(Request $request, YooKassaService $yooKassa)
    {
        if(!$request->room_number){

            session()->flash('wrong','Room number is empty !');
            return redirect()->route('cart.checkout');
        }
        if(!$request->delivery_date){

            session()->flash('wrong','Delivery Date is empty !');
            return redirect()->route('cart.checkout');
        }



        $data=array();

        $invoice = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
        Session::put('invoice',$invoice);
        $data['room_number']=$request->room_number;
        $data['product_order']="yes";
        $data['invoice_no']=$invoice;
        $data['pay_method']="Payment pending";
        $data['delivery_date']=$request->delivery_date;
        $data['purchase_date']=date("Y-m-d");

        if($request->place_order){

            $data['pay_method']="Cash On Delivery";
            $carts = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->update($data);

            $message = "order created";

            (new TelegramNotification())->send($message);
            return view('confirm_order',compact('invoice'));

        }

        $carts = DB::table('carts')->where('user_id',Auth::user()->id)->where('product_order','no')->update($data);

        $total=Session::get('total');
        $returnUrl = route('payment.success');

        $payment = $yooKassa->createPayment($total, $returnUrl);

        // Redirect user to Yandex Pay checkout
        return redirect($payment->getConfirmation()->getConfirmationUrl());
    }

    public function success()
    {

        $data['pay_method']="Payed Online";
        $invoice = Session::get('invoice');
        DB::table('carts')->where('user_id',Auth::user()->id)
            ->where('invoice_no',$invoice)
            ->update($data);


        $message = "order created";

        (new TelegramNotification())->send($message);

//            \Mail::send('mails.PaymentMail', $data, function($message)use($data, $pdf) {
//                $message->to(Auth::user()->email,Auth::user()->email)
//                        ->subject($data["title"])
//                        ->attachData($pdf->output(), "Order Copy.pdf");
//            });

        return view('payment_success',compact('invoice'));
    }


}
