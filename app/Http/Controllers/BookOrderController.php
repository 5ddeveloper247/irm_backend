<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\BookOrder;
use App\Models\BookLibrary;

class BookOrderController extends Controller
{
    //get orders
    public function bookorders(Request $request)
    {
        // get book orders list with payment
        // $data['book_orders'] = BookOrder::with('payment')->get();
        // return BookOrder::with('payment')->get();
        return view('admin.bookorders');
    }
    private function _status($status)
    {
        $statusName = '';
        // status 1=pendding, 2=shipped, 3=delivered, 4=completed
        switch ($status) {
            case 1:
                $statusName = 'Pendding';
                break;
            case 2:
                $statusName = 'Shipped';
                break;
            case 3:
                $statusName = 'Delivered';
                break;
            case 4:
                $statusName = 'Completed';
                break;
        }
        return $statusName;
    }
    // _getStatusActions
    private function _getStatusActions($status, $id)
    {
        $actions = [];
        // status 1=pendding, 2=shipped, 3=delivered, 4=completed
        // return next status button
        switch ($status) {
            case 1:
                $actions = '<button class="btn btn-danger btn-sm" onclick="statusUpdateBookOrderConfirm(' . $id . ')">Shipped</button>';
                break;
            case 2:
                $actions = '<button class="btn btn-primary btn-sm" onclick="statusUpdateBookOrderConfirm(' . $id . ')">Delivered</button>';
                break;
            case 3:
                $actions = '<button class="btn btn-success btn-sm" onclick="statusUpdateBookOrderConfirm(' . $id . ')">Completed</button>';
                break;
            case 4:
                $actions = '<button class="btn btn-dark btn-sm" disabled>Done</button>';
                break;
        }
        return $actions . '&nbsp;<button class="btn btn-info btn-sm" onclick="viewBookOrder(' . $id . ')">View</button>';
    }
    private function _getStatusOneAction($status, $id)
    {
        $actions = [];
        // status 1=pendding, 2=shipped, 3=delivered, 4=completed
        // return next status button
        switch ($status) {
            case 1:
                $actions = '<button class="btn btn-danger btn-sm" onclick="statusUpdateBookOrderConfirm(' . $id . ')">Shipped</button>';
                break;
            case 2:
                $actions = '<button class="btn btn-primary btn-sm" onclick="statusUpdateBookOrderConfirm(' . $id . ')">Delivered</button>';
                break;
            case 3:
                $actions = '<button class="btn btn-success btn-sm" onclick="statusUpdateBookOrderConfirm(' . $id . ')">Completed</button>';
                break;
            case 4:
                $actions = '<button class="btn btn-dark btn-sm" disabled>Done</button>';
                break;
        }
        return $actions;
    }
    private function _statusNameWithBadge($status)
    {
        $statusName = '';
        // status 1=pendding, 2=shipped, 3=delivered, 4=completed
        switch ($status) {
            case 1:
                $statusName = '<span class="badge bg-danger">Pendding</span>';
                break;
            case 2:
                $statusName = '<span class="badge bg-primary">Shipped</span>';
                break;
            case 3:
                $statusName = '<span class="badge bg-info">Delivered</span>';
                break;
            case 4:
                $statusName = '<span class="badge bg-success">Completed</span>';
                break;
        }
        return $statusName;
    }
    // get orders
    public function getBookOrders(Request $request)
    {
        // get book orders list with payment json data key convert to array
        $data['book_orders'] = BookOrder::with('book', 'payment')->orderBy('id', 'desc')->get()->map(function ($row) {
            return [
                'id' => $row->id,
                'amount' => $row->amount,
                'book_id' => $row->book_id,
                'payment_id' => $row->payment_id,
                'created_at' => $row->created_at,
                'json_data' => json_decode($row->data),
                'status' => $row->status,
                'payment' => $row->payment,
                'book' => $row->book,
                'statusName' => $this->_status($row->status),
                'action' => $this->_getStatusActions($row->status, $row->id)
            ];
        });
        // book payments
        $payments = BookOrder::with('book', 'payment')->latest()->get();

        return response()->json(['status' => 200, 'message' => "", 'data' => $data, 'payments'=> $payments]);
    }
    // get book orders page data
    public function getBookOrdersPageData(Request $request)
    {
        // get book orders list with payment and book name and get total payemnt sum and count
        $data['book_orders'] = BookOrder::join('payments', 'book_orders.payment_id', '=', 'payments.id')
            ->join('books_library', 'book_orders.book_id', '=', 'books_library.id')
            ->select('book_orders.*', 'payments.amount', 'books_library.title as book_name', 'books_library.price as book_amount')
            ->get()
            ->groupBy('book_name')
            ->map(function ($rows) {
                return [
                    'created_at' => $rows->first()->created_at,
                    'book_name' => $rows->first()->book_name,
                    'id' => $rows->first()->book_id,
                    'orders' => $rows,
                    'total_payment' => $rows->sum('amount'),
                    'order_count' => $rows->count(),
                    'book_amount' => (float)$rows->first()->book_amount
                ];
            })->values();
        // $data['book_orders'] = BookOrder::with('payment','book')->get();

        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // changeStatus
    public function changeStatus(Request $request)
    {
        // get book order by id
        $bookOrder = BookOrder::find($request->id);
        // dd($bookOrder->status);
        // set next status
        switch ($bookOrder->status) {
            case 1:
                $bookOrder->status = 2;
                break;
            case 2:
                $bookOrder->status = 3;
                break;
            case 3:
                $bookOrder->status = 4;
                break;
            case 4:
                $bookOrder->status = 4;
                break;
            default:
                $bookOrder->status = 1;
                break;
        }

        // update status
        $bookOrder->save();
        return response()->json(['status' => 200, 'message' => "Status updated successfully", 'data' => $bookOrder]);
    }
    // view book order
    public function viewBookOrder(Request $request)
    {
        // get book order by id
        $bookOrder = BookOrder::with('book', 'payment')->find($request->id);
        // json data convert to array
        $bookOrder->json_data = json_decode($bookOrder->data);
        // set status name
        $bookOrder->statusName = $this->_status($bookOrder->status);
        // set action button
        $bookOrder->action = $this->_getStatusOneAction($bookOrder->status, $bookOrder->id);
        $bookOrder->statusNameWithBadge = $this->_statusNameWithBadge($bookOrder->status);
        return response()->json(['status' => 200, 'message' => "", 'data' => $bookOrder]);
    }
}
