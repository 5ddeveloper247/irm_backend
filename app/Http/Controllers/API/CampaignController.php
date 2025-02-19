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
use App\Http\Controllers\WhatsAppController;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller

{
    public function calculateProgress($current, $target) {
        if ($target == 0) {
            return 0; // Avoid division by zero, set progress to 0%
        }
    
        $progress = ($current / $target) * 100;
        return min(round($progress, 2), 100); // Cap at 100%
    }
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
            // progress percentage
            $data['campaign_list'][$key]->progress = $this->calculateProgress($value->total_amount, $value->target_amount);
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
        // Remove extra ".00" from the amount string
        $amountString = $request->input('amount');
        $amountString = preg_replace('/\.00$/', '', $amountString);
        $amount = floatval($amountString) * 100; // Amount in cents
        $data['amount'] = $amount;
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the payment method ID from the request
        $paymentMethodId = $request->input('paymentMethodId');
        // $amount = $request->input('amount') * 100; // Amount in cents
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
            $payment = DB::table('payments')->insertGetId([
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
            // get payment id
            $data['shipping'] = $data['donatation_submit'];
            $json = json_encode($data, true);
            if($data['donatation_submit']['module_code'] == 'BOOK'){
                DB::table('book_orders')->insert([
                    'amount' => $paymentIntent->amount/100,
                    'payment_id' => $payment,
                    'book_id' => $compaign_id,
                    'status' => 1,
                    'data' => $json,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                // send message to whatsapp
                $whatsapp = new WhatsAppController();
                if (isset($data['donatation_submit']['phoneNumber'])) {
                    $phoneNumber = $data['donatation_submit']['phoneNumber'];
                    if (strpos($phoneNumber, '+') !== 0) {
                        $phoneNumber = '+' . $phoneNumber;
                    }
                    $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},\n\n";
                    $message .= "Thank you for your book order! Your order has been placed successfully. Here are the details:\n\n";
                    $message .= "Order ID: {$payment}\n";
                    $message .= "Book Title: {$data['donatation_submit']['custom_task_name']}\n";
                    $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}\n";
                    $message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}\n";
                    $message .= "Email: {$data['donatation_submit']['email']}\n\n";
                    $message .= "We will notify you once your book is on its way!\n\n";
                    $message .= "Thank you for your purchase!";
                    
                    $whatsAppResponse = $whatsapp->sendMessage($phoneNumber, $message);
                } else {
                    $whatsAppResponse = 'Phone number not provided';
                }
                // send emai
                $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},<br><br>";
                $message .= "Thank you for your book order! Your order has been placed successfully. Here are the details:<br><br>";
                $message .= "Order ID: {$payment}<br>";
                $message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
                $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
                $message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
                $message .= "Email: {$data['donatation_submit']['email']}<br><br>";
                $message .= "We will notify you once your book is on its way!<br><br>";
                $message .= "Thank you for your purchase!";
                $to_name = $data['donatation_submit']['firstName'];
                $to_email = $data['donatation_submit']['email'];
                $subject = "Book Order Confirmation";
                try{
                    // mail for customer
                    sendMail($to_name, $to_email, $subject, $message);
                    
                    $admin_message = "New book order has been placed.<br><br>";
                    $admin_message .= "Order ID: {$payment}<br>";
                    $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
                    $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
                    $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}<br>";
                    $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
                    $admin_message .= "Email: {$data['donatation_submit']['email']}<br><br>";
                    $admin_message .= "Please process the order as soon as possible.";
                    // send email to admin
                    // get super admin
                    $admin = User::where('role', 1)->first() ?? null;
                    if($admin){
                        sendMail($admin->name, $admin->email, 'Admin New Book Order', $admin_message);
                    }
                    $setting = Setting::first() ?? null;
                    $company_phone = $setting->company_phone;
                    $company_email = $setting->company_email;
                    // send message to whatsapp to company
                    if($company_phone && $company_phone != ''){
                        $admin_message = "New book order has been placed.\n\n";
                        $admin_message .= "Order ID: {$payment}\n";
                        $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}\n";
                        $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}\n";
                        $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}\n";
                        $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}\n";
                        $admin_message .= "Email: {$data['donatation_submit']['email']}\n\n";
                        $admin_message .= "Please process the order as soon as possible.";
                        $whatsAppResponse = $whatsapp->sendMessage($company_phone, $admin_message);
                    }
                    // send email to company
                    if($company_email && $company_email != ''){
                        $admin_message = "New book order has been placed.<br><br>";
                        $admin_message .= "Order ID: {$payment}<br>";
                        $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
                        $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
                        $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}<br>";
                        $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
                        $admin_message .= "Email: {$data['donatation_submit']['email']}<br><br>";
                        $admin_message .= "Please process the order as soon as possible.";
                        sendMail($setting->company_name, $setting->company_email, 'Company New Book Order', $admin_message);
                    }
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                }
            }
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'details' => $paymentIntent,
                 'status' => 200, 'message' => "", 
                 'data' => $data, 
                 'success' => true,
                 'payment'=> $payment
                //  'whatsAppResponse' => $whatsAppResponse
                ]);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
