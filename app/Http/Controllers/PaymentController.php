<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\BookLibrary as Book;
use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;

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
        $query = Payment::latest();

        // module_code filter
        if (request()->has('module_code') && request('module_code') != '') {
            $query->where('module_code', request('module_code'));
        }

        // price filter
        if (request()->has('price') && request('price') != '') {
            $query->where('amount', request('price'));
        }

        // payment_indent filter
        if (request()->has('payment_indent') && request('payment_indent') != '') {
            $query->where('payment_intent', request('payment_indent'));
        }

        // date filter
        if (request()->has('date') && request('date') != '') {
            $query->whereDate('created_at', request('date'));
        }

        $data['payment_list'] = $query->get();

        // get book name or campaign title based on module code
        foreach ($data['payment_list'] as $key => $value) {
            $data['payment_list'][$key]->data2 = json_decode($value->data);
            $data['payment_list'][$key]->payment_intent = $value->payment_intent ?? uniqid();

            if ($value->module_code == 'BOOK') {
                $book = Book::find($value->compaign_id);
                $data['payment_list'][$key]->module_title = $book->title ?? 'N/A';
            } elseif ($value->module_code == 'CAMPAIGN') {
                $campaign = Campaign::find($value->compaign_id);
                $data['payment_list'][$key]->module_title = $campaign->title ?? 'N/A';
            }

            // Add receipt URL if exists
            if ($value->receipt_path) {
                $data['payment_list'][$key]->receipt_url = url('storage/' . $value->receipt_path);
            }

            // Add action buttons HTML
            $data['payment_list'][$key]->action_buttons = $this->getActionButtons($value);
        }

        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    // get only campaign payments
    public function getCampaignPayments(Request $request)
    {
        $query = Payment::with('campaign')->where('module_code', 'CAMPAIGN')->latest();

        // campaign_title filter
        if (request()->has('campaign_title') && request('campaign_title') != '') {
            $query->whereHas('campaign', function ($q) {
                $q->where('title', 'like', '%' . request('campaign_title') . '%');
            });
        }

        // payment_amount filter
        if (request()->has('payment_amount') && request('payment_amount') != '') {
            $query->where('amount', request('payment_amount'));
        }

        // payment_indent filter
        if (request()->has('payment_indent') && request('payment_indent') != '') {
            $query->where('payment_intent', request('payment_indent'));
        }

        // payment_date filter
        if (request()->has('payment_date') && request('payment_date') != '') {
            $query->whereDate('created_at', request('payment_date'));
        }

        // payment_status filter
        if (request()->has('payment_status') && request('payment_status') != '') {
            $query->where('status', request('payment_status'));
        }

        $data['payment_list'] = $query->get();

        // data field to json decode
        foreach ($data['payment_list'] as $key => $value) {
            $data['payment_list'][$key]->data2 = json_decode($value->data);
        }

        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }

    // Get action buttons HTML based on payment status
    private function getActionButtons($payment)
    {
        $buttons = '<div class="btn-group">';

        // View button - always visible

        $buttons .= '<button class="btn btn-info btn-sm" onclick="viewPayment(' . $payment->id . ')" >
                        View
                    </button>';

        // Approve/Reject buttons - only for pending status
        if ($payment->status == 'pending') {
            $buttons .= '<button class="btn btn-sm btn-success ms-1" onclick="approvePayment(' . $payment->id . ')" >
                            Approve
                        </button>
                        <button class="btn btn-sm btn-danger ms-1" onclick="rejectPayment(' . $payment->id . ')" >
                            Reject
                        </button>';
        }

        $buttons .= '</div>';

        return $buttons;
    }

    // Get payment details
    public function getPaymentDetails(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $data = [
                'id' => $payment->id,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'payment_intent' => $payment->payment_intent,
                'payment_method' => $payment->payment_method ?? 'N/A',
                'module_code' => $payment->module_code,
                'created_at' => $payment->created_at->format('d M Y, h:i A'),
                'data' => json_decode($payment->data),
            ];

            // Add module title
            if ($payment->module_code == 'BOOK') {
                $book = Book::find($payment->compaign_id);
                $data['module_title'] = $book->title ?? 'N/A';
            } elseif ($payment->module_code == 'CAMPAIGN') {
                $campaign = Campaign::find($payment->compaign_id);
                $data['module_title'] = $campaign->title ?? 'N/A';
            } else {
                $data['module_title'] = 'N/A';
            }

            // Add category from donatation_submit
            if (isset($paymentData->donatation_submit->category)) {
                $data['category'] = $paymentData->donatation_submit->category;
            } elseif (isset($paymentData->donatation_submit->custom_task_name)) {
                $data['category'] = $paymentData->donatation_submit->custom_task_name;
            } else {
                $data['category'] = 'N/A';
            }

            // Add receipt information
            if ($payment->receipt_path) {
                $data['receipt_path'] = $payment->receipt_path;
                $data['receipt_url'] = url('storage/' . $payment->receipt_path);
                $data['receipt_name'] = basename($payment->receipt_path);

                // Check if it's an image or PDF
                $extension = strtolower(pathinfo($payment->receipt_path, PATHINFO_EXTENSION));
                $data['is_image'] = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                $data['is_pdf'] = $extension === 'pdf';
            } else {
                $data['receipt_path'] = null;
                $data['receipt_url'] = null;
            }

            return response()->json([
                'status' => 200,
                'message' => 'Payment details retrieved successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Payment not found'
            ], 404);
        }
    }

    // Approve payment
    public function approvePayment(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);

            if ($payment->status !== 'pending') {
                return response()->json([
                    'status' => 400,
                    'message' => 'Only pending payments can be approved'
                ], 400);
            }

            $payment->status = 'succeeded';
            $payment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error approving payment: ' . $e->getMessage()
            ], 500);
        }
    }

    // Reject payment
    public function rejectPayment(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);

            if ($payment->status !== 'pending') {
                return response()->json([
                    'status' => 400,
                    'message' => 'Only pending payments can be rejected'
                ], 400);
            }

            $payment->status = 'failed';
            $payment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error rejecting payment: ' . $e->getMessage()
            ], 500);
        }
    }
}
