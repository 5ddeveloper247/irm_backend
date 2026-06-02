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
use Illuminate\Support\Facades\Validator;
use App\Services\CampaignService;

class CampaignController extends Controller

{
    public function __construct(private CampaignService $campaignService)
    {
    }

    public function calculateProgress($current, $target)
    {
        if ($target == 0) {
            return 0; // Avoid division by zero, set progress to 0%
        }

        $progress = ($current / $target) * 100;
        return min(round($progress, 2), 100); // Cap at 100%
    }
    //
    public function getCampaigns(Request $request)
    {
        $section = $request->query('section') ?? $request->query('welfare_section');

        $query = Campaign::leftJoin('payments', function ($join) {
            $join->on('campaigns.id', '=', 'payments.compaign_id')
                ->whereIn('payments.module_code', ['CAMPAIGN', 'DONATION']);
        })
            ->select('campaigns.*', DB::raw('COALESCE(SUM(payments.amount), 0) as total_amount'))
            ->where('campaigns.status', 1)
            ->groupBy('campaigns.id');

        if (!empty($section) && $section !== 'all') {
            $query->where('campaigns.welfare_section', $section);
        }

        $campaignList = $query
            ->orderByDesc('campaigns.display_order')
            ->orderByDesc('campaigns.id')
            ->get()
            ->map(fn ($campaign) => $this->campaignService->formatCampaignForApi(
                $campaign,
                (float) ($campaign->total_amount ?? 0)
            ));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'campaign_list' => $campaignList,
                'payment_accounts' => $this->campaignService->getPaymentAccounts(),
                'currency' => 'PKR',
                'currency_symbol' => 'Rs',
            ],
        ]);
    }

    public function getSpecificCampaign(Request $request, $id)
    {
        $campaign = Campaign::where('id', $id)->where('status', 1)->with(['tasks'])->first();

        if (!$campaign) {
            return response()->json(['status' => 404, 'message' => 'Campaign not found']);
        }

        $totalAmount = (float) DB::table('payments')
            ->where('compaign_id', $id)
            ->whereIn('module_code', ['CAMPAIGN', 'DONATION'])
            ->sum('amount');

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'campaign_detail' => $this->campaignService->formatCampaignForApi($campaign, $totalAmount),
                'payment_accounts' => $this->campaignService->getPaymentAccounts(),
            ],
        ]);
    }

    // public function stripePayment(Request $request)
    // {
    //     // Remove extra ".00" from the amount string
    //     $amountString = $request->input('amount');
    //     $amountString = preg_replace('/\.00$/', '', $amountString);
    //     $amount = floatval($amountString) * 100; // Amount in cents
    //     $data['amount'] = $amount;
    //     // Set your Stripe secret key
    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     // Retrieve the payment method ID from the request
    //     $paymentMethodId = $request->input('paymentMethodId');
    //     // $amount = $request->input('amount') * 100; // Amount in cents
    //     // return response()->json(['status' => 200, 'message' => "", 'data' => $amount,'amount' => $amount,
    //     //         'currency' => 'pkr',
    //     //         'payment_method' => $paymentMethodId,
    //     //         'confirm' => true, // Immediately confirm the payment
    //     //         'automatic_payment_methods' => [
    //     //             'enabled' => true,
    //     //             'allow_redirects' => 'never',
    //     //         ],]);
    //     try {
    //         // Create a PaymentIntent with the payment method
    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => $amount,
    //             'currency' => 'pkr',
    //             'payment_method' => $paymentMethodId,
    //             'confirm' => true, // Immediately confirm the payment
    //             'automatic_payment_methods' => [
    //                 'enabled' => true,
    //                 'allow_redirects' => 'never',
    //             ],
    //         ]);
    //         // get transaction id
    //         // get payment intent and other info for database
    //         $data = $request->all();
    //         // dd($data['donatation_submit']['module_code']);
    //         // merge $paymentIndent with $data
    //         $data['paymentIntent'] = $paymentIntent;
    //         // get transaction id
    //         $data['donatation_submit']['transaction_id'] = $paymentIntent->id;
    //         $compaign_id = isset($data['donatation_submit']['campaign_id']) ? $data['donatation_submit']['campaign_id'] : 0;
    //         if(is_null($compaign_id)){
    //             $compaign_id = 0;
    //         }
    //         $task_id = $data['donatation_submit']['task_id'];
    //         // convert to string
    //         $task_id = implode(',', $task_id);
    //         // convert data to json
    //         $json = json_encode($data, true);
    //         $payment = DB::table('payments')->insertGetId([
    //             'client_secret' => $paymentIntent->client_secret,
    //             'data' => $json,
    //             'task_id' => $task_id,
    //             'compaign_id' => $compaign_id,
    //             'amount' => $paymentIntent->amount/100,
    //             'status' => $paymentIntent->status,
    //             'payment_intent' => $paymentIntent->id,
    //             'module_code' => (isset($data['donatation_submit']['module_code'])) ? $data['donatation_submit']['module_code'] : 'DONATION',
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s')
    //         ]);
    //         // get payment id
    //         $data['shipping'] = $data['donatation_submit'];
    //         $json = json_encode($data, true);
    //         if($data['donatation_submit']['module_code'] == 'BOOK'){
    //             DB::table('book_orders')->insert([
    //                 'amount' => $paymentIntent->amount/100,
    //                 'payment_id' => $payment,
    //                 'book_id' => $compaign_id,
    //                 'status' => 1,
    //                 'data' => $json,
    //                 'created_at' => date('Y-m-d H:i:s'),
    //                 'updated_at' => date('Y-m-d H:i:s')
    //             ]);
    //             // send message to whatsapp
    //             $whatsapp = new WhatsAppController();
    //             if (isset($data['donatation_submit']['phoneNumber'])) {
    //                 $phoneNumber = $data['donatation_submit']['phoneNumber'];
    //                 if (strpos($phoneNumber, '+') !== 0) {
    //                     $phoneNumber = '+' . $phoneNumber;
    //                 }
    //                 $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},\n\n";
    //                 $message .= "Thank you for your book order! Your order has been placed successfully. Here are the details:\n\n";
    //                 $message .= "Order ID: {$payment}\n";
    //                 $message .= "Book Title: {$data['donatation_submit']['custom_task_name']}\n";
    //                 $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}\n";
    //                 $message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}\n";
    //                 $message .= "Email: {$data['donatation_submit']['email']}\n\n";
    //                 $message .= "We will notify you once your book is on its way!\n\n";
    //                 $message .= "Thank you for your purchase!";

    //                 $whatsAppResponse = $whatsapp->sendMessage($phoneNumber, $message);
    //             } else {
    //                 $whatsAppResponse = 'Phone number not provided';
    //             }
    //             // send emai
    //             $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},<br><br>";
    //             $message .= "Thank you for your book order! Your order has been placed successfully. Here are the details:<br><br>";
    //             $message .= "Order ID: {$payment}<br>";
    //             $message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
    //             $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
    //             $message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
    //             $message .= "Email: {$data['donatation_submit']['email']}<br><br>";
    //             $message .= "We will notify you once your book is on its way!<br><br>";
    //             $message .= "Thank you for your purchase!";
    //             $to_name = $data['donatation_submit']['firstName'];
    //             $to_email = $data['donatation_submit']['email'];
    //             $subject = "Book Order Confirmation";
    //             try{
    //                 // mail for customer
    //                 sendMail($to_name, $to_email, $subject, $message);

    //                 $admin_message = "New book order has been placed.<br><br>";
    //                 $admin_message .= "Order ID: {$payment}<br>";
    //                 $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
    //                 $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
    //                 $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}<br>";
    //                 $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
    //                 $admin_message .= "Email: {$data['donatation_submit']['email']}<br><br>";
    //                 $admin_message .= "Please process the order as soon as possible.";
    //                 // send email to admin
    //                 // get super admin
    //                 $admin = User::where('role', 1)->first() ?? null;
    //                 if($admin){
    //                     sendMail($admin->name, $admin->email, 'Admin New Book Order', $admin_message);
    //                 }
    //                 $setting = Setting::first() ?? null;
    //                 $company_phone = $setting->company_phone;
    //                 $company_email = $setting->company_email;
    //                 // send message to whatsapp to company
    //                 if($company_phone && $company_phone != ''){
    //                     $admin_message = "New book order has been placed.\n\n";
    //                     $admin_message .= "Order ID: {$payment}\n";
    //                     $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}\n";
    //                     $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}\n";
    //                     $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}\n";
    //                     $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}\n";
    //                     $admin_message .= "Email: {$data['donatation_submit']['email']}\n\n";
    //                     $admin_message .= "Please process the order as soon as possible.";
    //                     $whatsAppResponse = $whatsapp->sendMessage($company_phone, $admin_message);
    //                 }
    //                 // send email to company
    //                 if($company_email && $company_email != ''){
    //                     $admin_message = "New book order has been placed.<br><br>";
    //                     $admin_message .= "Order ID: {$payment}<br>";
    //                     $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
    //                     $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
    //                     $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}<br>";
    //                     $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
    //                     $admin_message .= "Email: {$data['donatation_submit']['email']}<br><br>";
    //                     $admin_message .= "Please process the order as soon as possible.";
    //                     sendMail($setting->company_name, $setting->company_email, 'Company New Book Order', $admin_message);
    //                 }
    //             }catch(\Exception $e){
    //                 Log::error($e->getMessage());
    //             }
    //         }
    //         // email send for donation and campaign
    //         if($data['donatation_submit']['module_code'] == 'DONATION' || $data['donatation_submit']['module_code'] == 'CAMPAIGN'){
    //             // send message to whatsapp
    //             // $whatsapp = new WhatsAppController();
    //             // if (isset($data['donatation_submit']['phoneNumber'])) {
    //             //     $phoneNumber = $data['donatation_submit']['phoneNumber'];
    //             //     if (strpos($phoneNumber, '+') !== 0) {
    //             //         $phoneNumber = '+' . $phoneNumber;
    //             //     }
    //             //     $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},\n\n";
    //             //     $message .= "Thank you for your donation! Your donation has been placed successfully. Here are the details:\n\n";
    //             //     $message .= "Order ID: {$payment}\n";
    //             //     $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}\n";
    //             //     $message .= "Email: {$data['donatation_submit']['email']}\n\n";
    //             //     $message .= "We will notify you once your donation is processed!\n\n";
    //             //     $message .= "Thank you for your donation!";

    //             //     $whatsAppResponse = $whatsapp->sendMessage($phoneNumber, $message);
    //             // } else {
    //             //     $whatsAppResponse = 'Phone number not provided';

    //             // send emai
    //             $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},<br><br>";
    //             $message .= "Thank you for your donation! Your donation has been placed successfully. Here are the details:<br><br>";
    //             $message .= "Order ID: {$payment}<br>";
    //             $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} {$data['currency']}<br>";
    //             $message .= "Email: {$data['donatation_submit']['email']}<br><br>";
    //             $message .= "We will notify you once your donation is processed!<br><br>";
    //             $message .= "Thank you for your donation!";
    //             $to_name = $data['donatation_submit']['firstName'];
    //             $to_email = $data['donatation_submit']['email'];
    //             $subject = "Donation Confirmation";
    //             try{
    //                 // mail for customer
    //                 sendMail($to_name, $to_email, $subject, $message);
    //                 // Log::info($to_name.'-'.$to_email.'-'.$subject.sendMail($to_name, $to_email, $subject, $message));
    //             }catch(\Exception $e){
    //                 Log::error($e->getMessage());
    //             }
    //         }
    //         return response()->json([
    //             'clientSecret' => $paymentIntent->client_secret,
    //             'details' => $paymentIntent,
    //              'status' => 200, 'message' => "", 
    //              'data' => $data, 
    //              'success' => true,
    //              'payment'=> $payment
    //             //  'whatsAppResponse' => $whatsAppResponse
    //             ]);
    //     } catch (ApiErrorException $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    public function manualPayment(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'donatation_submit' => 'required|array',
            'donatation_submit.module_code' => 'required|in:DONATION,CAMPAIGN,BOOK',
            'donatation_submit.task_id' => 'nullable|array',
            'donatation_submit.campaign_id' => 'nullable|integer',
            'donatation_submit.course_id' => 'nullable|integer',
            'donatation_submit.custom_task_name' => 'nullable|string|max:255',
            'donatation_submit.custom_task_amount' => 'nullable|numeric|min:0',
            'donatation_submit.total_amount' => 'nullable|numeric|min:0',
            'donatation_submit.firstName' => 'nullable|string|max:255',
            'donatation_submit.lastName' => 'nullable|string|max:255',
            'donatation_submit.email' => 'nullable|email|max:255',
            'donatation_submit.phoneNumber' => 'nullable|string|max:20',
            'donatation_submit.streetAddress' => 'nullable|string|max:500',
            'donatation_submit.category' => 'nullable|string|max:255',
            'donatation_submit.country' => 'nullable|string|max:100',
            'donatation_submit.city' => 'nullable|string|max:100',
            'payment_method' => 'required|string|in:jazz_cash,easypaisa,bank_transfer',
            'receipt_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $data = $request->all();
            $submit = $data['donatation_submit'] ?? [];

            if (empty($submit['campaign_id']) && !empty($submit['course_id'])) {
                $data['donatation_submit']['campaign_id'] = $submit['course_id'];
            }

            if (in_array($data['donatation_submit']['module_code'] ?? '', ['DONATION', 'CAMPAIGN'], true)) {
                $donationError = $this->campaignService->validateDonationCampaign(
                    $this->campaignService->resolveCampaignId($data['donatation_submit'])
                );

                if ($donationError) {
                    return response()->json(['status' => 400, 'message' => $donationError], 400);
                }
            }

            if (($data['donatation_submit']['module_code'] ?? '') === 'BOOK') {
                $bookError = app(\App\Services\BookService::class)->validateBookOrder(
                    $data['donatation_submit'],
                    (float) preg_replace('/\.00$/', '', (string) $request->input('amount'))
                );

                if ($bookError) {
                    return response()->json(['status' => 400, 'message' => $bookError], 400);
                }
            }

            $amountString = $request->input('amount');
            $amountString = preg_replace('/\.00$/', '', $amountString);
            $amount = floatval($amountString);

            $transactionId = 'MANUAL_' . time() . '_' . rand(1000, 9999);

            $data['transaction_id'] = $transactionId;
            $data['payment_status'] = 'pending';
            $data['currency'] = 'PKR';

            // Set default values for missing personal information fields
            if (!isset($data['donatation_submit']['category']) || empty($data['donatation_submit']['category'])) {
            $data['donatation_submit']['category'] = $data['donatation_submit']['custom_task_name'] ?? 'N/A';
        }
            if (!isset($data['donatation_submit']['firstName']) || empty($data['donatation_submit']['firstName'])) {
                $data['donatation_submit']['firstName'] = 'N/A';
            }
            if (!isset($data['donatation_submit']['lastName']) || empty($data['donatation_submit']['lastName'])) {
                $data['donatation_submit']['lastName'] = 'N/A';
            }
            if (!isset($data['donatation_submit']['email']) || empty($data['donatation_submit']['email'])) {
                $data['donatation_submit']['email'] = 'N/A';
            }
            if (!isset($data['donatation_submit']['phoneNumber']) || empty($data['donatation_submit']['phoneNumber'])) {
                $data['donatation_submit']['phoneNumber'] = 'N/A';
            }
            if (!isset($data['donatation_submit']['streetAddress']) || empty($data['donatation_submit']['streetAddress'])) {
                $data['donatation_submit']['streetAddress'] = 'N/A';
            }
            if (!isset($data['donatation_submit']['country']) || empty($data['donatation_submit']['country'])) {
                $data['donatation_submit']['country'] = 'N/A';
            }
            if (!isset($data['donatation_submit']['city']) || empty($data['donatation_submit']['city'])) {
                $data['donatation_submit']['city'] = 'N/A';
            }

            // Handle receipt file upload if provided
            $receiptPath = null;
            if ($request->hasFile('receipt_file')) {
                $receiptPath = $request->file('receipt_file')->store('receipts', 'public');
                $data['receipt_path'] = $receiptPath;
            }

            $compaign_id = $this->campaignService->resolveCampaignId($data['donatation_submit']) ?? 0;

            if ($data['donatation_submit']['module_code'] === 'BOOK') {
                $compaign_id = $data['donatation_submit']['book_id']
                    ?? $data['donatation_submit']['campaign_id']
                    ?? 0;
                $data['donatation_submit']['book_id'] = $compaign_id;
                $data['donatation_submit']['payment_type'] = 'book_order';
                $data['donatation_submit']['is_donation'] = false;
            } elseif (in_array($data['donatation_submit']['module_code'], ['DONATION', 'CAMPAIGN'], true)) {
                $data['donatation_submit']['payment_type'] = 'donation';
                $data['donatation_submit']['is_donation'] = true;
                $data['donatation_submit']['campaign_id'] = $compaign_id;
            }

            $task_id = isset($data['donatation_submit']['task_id']) ? $data['donatation_submit']['task_id'] : [];
            // convert to string
            $task_id = is_array($task_id) ? implode(',', $task_id) : $task_id;

            // Set transaction details for manual payment
            $data['donatation_submit']['transaction_id'] = $transactionId;

            // Ensure custom_task_amount and total_amount are set properly
            if (!isset($data['donatation_submit']['custom_task_amount']) || empty($data['donatation_submit']['custom_task_amount'])) {
                $data['donatation_submit']['custom_task_amount'] = $amount;
            }
            if (!isset($data['donatation_submit']['total_amount']) || empty($data['donatation_submit']['total_amount'])) {
                $data['donatation_submit']['total_amount'] = $amount;
            }

            // Convert data to json
            $json = json_encode($data, true);

            // Insert payment record
            $payment = DB::table('payments')->insertGetId([
                'client_secret' => null, // No client secret for manual payments
                'data' => $json,
                'task_id' => $task_id,
                'compaign_id' => $compaign_id,
                'amount' => $amount,
                'status' => 'pending', // Manual payments start as pending
                'payment_intent' => $transactionId,
                'payment_method' => $request->input('payment_method'),
                'receipt_path' => $receiptPath,
                'module_code' => $data['donatation_submit']['module_code'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Handle book orders
            if ($data['donatation_submit']['module_code'] == 'BOOK') {
                $data['shipping'] = $data['donatation_submit'];
                $json = json_encode($data, true);

                DB::table('book_orders')->insert([
                    'amount' => $amount,
                    'payment_id' => $payment,
                    'book_id' => $compaign_id,
                    'status' => 1, // Pending status for manual payment
                    'data' => $json,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // Send confirmation messages for book orders
                $this->sendBookOrderNotifications($data, $payment);
            }

            // Handle donations and campaigns
            if ($data['donatation_submit']['module_code'] == 'DONATION' || $data['donatation_submit']['module_code'] == 'CAMPAIGN') {
                $this->sendDonationNotifications($data, $payment);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Payment submitted successfully and is pending verification',
                'data' => [
                    'payment_id' => $payment,
                    'transaction_id' => $transactionId,
                    'amount' => $amount,
                    'status' => 'pending',
                    'payment_method' => $request->input('payment_method'),
                    'receipt_uploaded' => !is_null($receiptPath),
                    'module_code' => $data['donatation_submit']['module_code'],
                    'currency' => 'PKR',
                    'currency_symbol' => 'Rs',
                    'payment_type' => $data['donatation_submit']['payment_type'] ?? $data['donatation_submit']['module_code'],
                    'is_donation' => $data['donatation_submit']['is_donation'] ?? ($data['donatation_submit']['module_code'] !== 'BOOK'),
                    'campaign_id' => $data['donatation_submit']['campaign_id'] ?? null,
                    'book_id' => $data['donatation_submit']['book_id'] ?? null,
                    'custom_task_name' => $data['donatation_submit']['custom_task_name'] ?? 'N/A',
                    'category' => $data['donatation_submit']['category'] ?? 'N/A',
                    'billing_info' => [
                        'firstName' => $data['donatation_submit']['firstName'],
                        'lastName' => $data['donatation_submit']['lastName'],
                        'email' => $data['donatation_submit']['email'],
                        'phoneNumber' => $data['donatation_submit']['phoneNumber'],
                        'address' => $data['donatation_submit']['streetAddress'],
                        'country' => $data['donatation_submit']['country'],
                        'city' => $data['donatation_submit']['city']
                    ]
                ],
                'success' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Manual Payment Error: ' . $e->getMessage());
            Log::error('Manual Payment Stack Trace: ' . $e->getTraceAsString());
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while processing your payment',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    private function sendBookOrderNotifications($data, $paymentId)
    {
        try {
            $whatsapp = new WhatsAppController();

            // Send WhatsApp message to customer
            if (isset($data['donatation_submit']['phoneNumber'])) {
                $phoneNumber = $data['donatation_submit']['phoneNumber'];
                if (strpos($phoneNumber, '+') !== 0) {
                    $phoneNumber = '+' . $phoneNumber;
                }

                $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},\n\n";
                $message .= "Thank you for your book order! Your order has been submitted and is pending verification. Here are the details:\n\n";
                $message .= "Order ID: {$paymentId}\n";
                $message .= "Book Title: {$data['donatation_submit']['custom_task_name']}\n";
                $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} PKR\n";
                $message .= "Payment Method: {$data['payment_method']}\n";
                $message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}\n";
                $message .= "Email: {$data['donatation_submit']['email']}\n\n";
                $message .= "We will verify your payment and notify you once your book is confirmed!\n\n";
                $message .= "Thank you for your purchase!";

                $whatsapp->sendMessage($phoneNumber, $message);
            }

            // Send email to customer
            $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},<br><br>";
            $message .= "Thank you for your book order! Your order has been submitted and is pending verification. Here are the details:<br><br>";
            $message .= "Order ID: {$paymentId}<br>";
            $message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
            $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} PKR<br>";
            $message .= "Payment Method: " . ucfirst(str_replace('_', ' ', $data['payment_method'])) . "<br>";
            $message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
            $message .= "Email: {$data['donatation_submit']['email']}<br><br>";
            $message .= "We will verify your payment and notify you once your book is confirmed!<br><br>";
            $message .= "Thank you for your purchase!";

            $to_name = $data['donatation_submit']['firstName'];
            $to_email = $data['donatation_submit']['email'];
            $subject = "Book Order Confirmation - Pending Verification";

            sendMail($to_name, $to_email, $subject, $message);

            // Send notifications to admin
            $this->sendAdminBookOrderNotification($data, $paymentId);
        } catch (\Exception $e) {
            Log::error('Book Order Notification Error: ' . $e->getMessage());
        }
    }

    private function sendDonationNotifications($data, $paymentId)
    {
        try {
            $message = "Hello {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']},<br><br>";
            $message .= "Thank you for your donation! Your donation has been submitted and is pending verification. Here are the details:<br><br>";
            $message .= "Donation ID: {$paymentId}<br>";
            $message .= "Amount: {$data['donatation_submit']['custom_task_amount']} PKR<br>";
            $message .= "Payment Method: " . ucfirst(str_replace('_', ' ', $data['payment_method'])) . "<br>";
            $message .= "Email: {$data['donatation_submit']['email']}<br><br>";
            $message .= "We will verify your payment and notify you once your donation is confirmed!<br><br>";
            $message .= "Thank you for your generous donation!";

            $to_name = $data['donatation_submit']['firstName'];
            $to_email = $data['donatation_submit']['email'];
            $subject = "Donation Confirmation - Pending Verification";

            sendMail($to_name, $to_email, $subject, $message);
        } catch (\Exception $e) {
            Log::error('Donation Notification Error: ' . $e->getMessage());
        }
    }

    private function sendAdminBookOrderNotification($data, $paymentId)
    {
        try {
            // Send to super admin
            $admin = User::where('role', 1)->first();
            if ($admin) {
                $admin_message = "New book order has been placed (Pending Verification).<br><br>";
                $admin_message .= "Order ID: {$paymentId}<br>";
                $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
                $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} PKR<br>";
                $admin_message .= "Payment Method: " . ucfirst(str_replace('_', ' ', $data['payment_method'])) . "<br>";
                $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}<br>";
                $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
                $admin_message .= "Email: {$data['donatation_submit']['email']}<br><br>";
                $admin_message .= "Please verify the payment receipt and process the order.";

                sendMail($admin->name, $admin->email, 'New Book Order - Pending Verification', $admin_message);
            }

            // Send to company
            $setting = Setting::first();
            if ($setting && $setting->company_email) {
                $admin_message = "New book order has been placed (Pending Verification).<br><br>";
                $admin_message .= "Order ID: {$paymentId}<br>";
                $admin_message .= "Book Title: {$data['donatation_submit']['custom_task_name']}<br>";
                $admin_message .= "Amount: {$data['donatation_submit']['custom_task_amount']} PKR<br>";
                $admin_message .= "Payment Method: " . ucfirst(str_replace('_', ' ', $data['payment_method'])) . "<br>";
                $admin_message .= "Customer Name: {$data['donatation_submit']['firstName']} {$data['donatation_submit']['lastName']}<br>";
                $admin_message .= "Shipping Address: {$data['donatation_submit']['streetAddress']}, {$data['donatation_submit']['city']}, {$data['donatation_submit']['country']}<br>";
                $admin_message .= "Email: {$data['donatation_submit']['email']}<br><br>";
                $admin_message .= "Please verify the payment receipt and process the order.";

                sendMail($setting->company_name, $setting->company_email, 'New Book Order - Pending Verification', $admin_message);
            }
        } catch (\Exception $e) {
            Log::error('Admin Notification Error: ' . $e->getMessage());
        }
    }
}
