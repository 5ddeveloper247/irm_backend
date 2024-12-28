<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignTask;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
class CampaignController extends Controller

{
    //
    public function getCampaigns(Request $request)
    {
        
        // get all campaigns and total amount sum from payments table
        $data['campaign_list'] = Campaign::leftJoin('payments', function($join) {
            $join->on('campaigns.id', '=', 'payments.compaign_id')
             ->where('payments.module_code', '=', 'CAMPAIGN');
        })
        ->select('campaigns.*', DB::raw('SUM(payments.amount) as total_amount'))
        ->groupBy('campaigns.id')
        ->get();

        // set base url on image
        foreach($data['campaign_list'] as $key => $value){
            $data['campaign_list'][$key]->image = url('/'.$value->thumbnail);
        }
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }
    public function getSpecificCampaign(Request $request, $id)
    {
        
        $data['campaign_detail'] = Campaign::where('id', $id)->with(['tasks'])->first();
        
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
        
    }

    public function stripePayment(Request $request)
    {
        
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the payment method ID from the request
        $paymentMethodId = $request->input('paymentMethodId');
        $amount = $request->input('amount') * 100; // Amount in cents
        // return response()->json(['status' => 200, 'message' => "", 'data' => $amount,'amount' => $amount,
        //         'currency' => 'pkr',
        //         'payment_method' => $paymentMethodId,
        //         'confirm' => true, // Immediately confirm the payment
        //         'automatic_payment_methods' => [
        //             'enabled' => true,
        //             'allow_redirects' => 'never',
        //         ],]);
        try {
            // Create a PaymentIntent with the payment method
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'pkr',
                'payment_method' => $paymentMethodId,
                'confirm' => true, // Immediately confirm the payment
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);
            // get transaction id
            // get payment intent and other info for database
            $data = $request->all();
            // dd($data['donatation_submit']['module_code']);
            // merge $paymentIndent with $data
            $data['paymentIntent'] = $paymentIntent;
            // get transaction id
            $data['donatation_submit']['transaction_id'] = $paymentIntent->id;
            $compaign_id = isset($data['donatation_submit']['campaign_id']) ? $data['donatation_submit']['campaign_id'] : 0;
            if(is_null($compaign_id)){
                $compaign_id = 0;
            }
            $task_id = $data['donatation_submit']['task_id'];
            // convert to string
            $task_id = implode(',', $task_id);
            // convert data to json
            $json = json_encode($data, true);
            DB::table('payments')->insert([
                'client_secret' => $paymentIntent->client_secret,
                'data' => $json,
                'task_id' => $task_id,
                'compaign_id' => $compaign_id,
                'amount' => $paymentIntent->amount/100,
                'status' => $paymentIntent->status,
                'payment_intent' => $paymentIntent->id,
                'module_code' => (isset($data['donatation_submit']['module_code'])) ? $data['donatation_submit']['module_code'] : 'DONATION',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'details' => $paymentIntent,
                 'status' => 200, 'message' => "", 
                 'data' => $data, 
                 'success' => true
                ]);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
