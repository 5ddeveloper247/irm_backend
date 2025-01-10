<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
class PaymentController extends Controller
{
    // payments
    public function payments(Request $request)
    {
       return view('admin.payments');
    }
    // getPaymentsPageData
    public function getPaymentsPageData(Request $request)
    {
        // get all payments with order by id desc
        $data['payment_list'] = Payment::orderBy('id', 'desc')->get();
        // $data['payment_list'] = Payment::all();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
}
