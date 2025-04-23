<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookLibrary;
use App\Models\BookCategory;

class BookLibraryController extends Controller
{
    // getBooks
    public function getBooks(Request $request)
    {
        // get query string
        $search = $request->query('search');
        $categoryId = $request->query('filter_category');

        // get books where status = 1
        $query = BookLibrary::where('status', 1);
        $is_check = false;
        // filter by category if provided
        if ($categoryId != 0) {
            $is_check = true;
            $query->where('book_category_id', $categoryId);
        }

        // filter by search term if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        // get filtered book list
        $data['book_list'] = $query->get();

        // set base url on image and pdf
        foreach ($data['book_list'] as $key => $value) {
            $data['book_list'][$key]->thumbnail = url('/' . $value->thumbnail);
            $data['book_list'][$key]->pdf = url('/' . $value->book);
        }

        // get category_list with status = 1
        $data['category_list'] = BookCategory::where('status', 1)->get();

        return response()->json(['status' => 200, 'message' => "", 'data' => $data, "is_check"=> $is_check]);
    }
    // get lastest four books
    public function getLastestBooks(Request $request)
    {
        // get lastest four books
        $data['book_list'] = BookLibrary::where('status', 1)->orderBy('id', 'desc')->limit(4)->get();
        // set base url on image
        foreach ($data['book_list'] as $key => $value) {
            $data['book_list'][$key]->thumbnail = url('/' . $value->thumbnail);
            // add base url pdf book
            $data['book_list'][$key]->pdf = url('/' . $value->book);
        }
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // get specific book
    public function getSpecificBook(Request $request, $id)
    {
        $data['book_detail'] = BookLibrary::where('id', $id)->first();
        // set base url on image
        $data['book_detail']->thumbnail = url('/' . $data['book_detail']->thumbnail);
        // add base url pdf book
        $data['book_detail']->pdf = url('/' . $data['book_detail']->book);
        return response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // download book pdf
    public function downloadBook(Request $request, $id)
    {
        $book = BookLibrary::where('id', $id)->first();
        $path = public_path($book->book);
        return response()->download($path);
    }
    // view book pdf
    public function viewBook(Request $request, $id)
    {
        $book = BookLibrary::where('id', $id)->first();
        $path = public_path($book->book);
        return response()->file($path);
    }

    

}
