<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\BookLibrary as Book;
use App\Models\Campaign;
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
        // $data['payment_list'] = Payment::orderBy('id', 'desc')->get();
        $query = Payment::latest();
        // module_code: 
        if(request()->has('module_code') && request('module_code') != ''){
            $query->where('module_code', request('module_code'));
        }
        // price: 
        if(request()->has('price') && request('price') != ''){
            $query->where('amount', request('price'));
        }
        // payment_indent: 
        if(request()->has('payment_indent') && request('payment_indent') != ''){
            $query->where('payment_intent', request('payment_indent'));
        }
        // date: 
        if(request()->has('date') && request('date') != ''){
            $query->whereDate('created_at', request('date'));
        }
        $data['payment_list'] = $query->get();
        // get book name or campaign title based on module code
        foreach ($data['payment_list'] as $key => $value) {
            $data['payment_list'][$key]->data2 = json_decode($value->data);
            // payment_list payment_intent is nnull then set N/A
            // $data['payment_list'][$key]->donatation_submit = $value->payment_intent ?? uniqid();
            $data['payment_list'][$key]->payment_intent = $value->payment_intent ?? uniqid();
            if($value->module_code == 'BOOK'){
                $book = Book::find($value->compaign_id);
                $data['payment_list'][$key]->module_title = $book->title ?? 'N/A';
            }elseif($value->module_code == 'CAMPAIGN'){
                $campaign = Campaign::find($value->compaign_id);
                $data['payment_list'][$key]->module_title = $campaign->title ?? 'N/A';
            }
        }
        // $data['payment_list'] = Payment::all();
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // get only book payments
    public function getCampaignPayments(Request $request)
    {
        // get all payments with order by id desc
        // $data['payment_list'] = Payment::with('campaign')->where('module_code', 'CAMPAIGN')->orderBy('id', 'desc')->get();
        $query = Payment::with('campaign')->where('module_code', 'CAMPAIGN')->latest();
        // campaign_title:
        if(request()->has('campaign_title') && request('campaign_title') != ''){
            $query->whereHas('campaign', function($q){
                $q->where('title', 'like', '%'.request('campaign_title').'%');
            });
        }
        // payment_amount: 
        if(request()->has('payment_amount') && request('payment_amount') != ''){
            $query->where('amount', request('payment_amount'));
        }
        // payment_indent: 
        if(request()->has('payment_indent') && request('payment_indent') != ''){
            $query->where('payment_intent', request('payment_indent'));
        }
        // payment_date: 
        if(request()->has('payment_date') && request('payment_date') != ''){
            $query->whereDate('created_at', request('payment_date'));
        }
        // payment_status: 
        if(request()->has('payment_status') && request('payment_status') != ''){
            $query->where('status', request('payment_status'));
        }
        $data['payment_list'] = $query->get();
        // data field to json decode
        foreach ($data['payment_list'] as $key => $value) {
            $data['payment_list'][$key]->data2 = json_decode($value->data);
        }
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
}
