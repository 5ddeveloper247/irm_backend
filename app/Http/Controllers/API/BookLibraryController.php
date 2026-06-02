<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use App\Models\BookLibrary;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookLibraryController extends Controller
{
    public function __construct(private BookService $bookService)
    {
    }

    public function getBooks(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('filter_category');
        $isCheck = false;

        $query = BookLibrary::with('bookcategory')->where('status', 1);

        if ($categoryId != 0) {
            $isCheck = true;
            $query->where('book_category_id', $categoryId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        $bookList = $query->orderByDesc('id')
            ->get()
            ->map(fn ($book) => $this->bookService->formatForApi($book));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'book_list' => $bookList,
                'category_list' => BookCategory::where('status', 1)->orderByDesc('id')->get(),
            ],
            'is_check' => $isCheck,
        ]);
    }

    public function getLastestBooks(Request $request)
    {
        $bookList = BookLibrary::with('bookcategory')
            ->where('status', 1)
            ->where('book_homepage', 1)
            ->orderByDesc('id')
            ->get()
            ->map(fn ($book) => $this->bookService->formatForApi($book));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => ['book_list' => $bookList],
        ]);
    }

    public function getSpecificBook(Request $request, $id)
    {
        $book = $this->bookService->resolveByIdOrSlug($id);

        if (!$book) {
            return response()->json(['status' => 404, 'message' => 'Book not found']);
        }

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'book_detail' => $this->bookService->formatForApi($book, true),
            ],
        ]);
    }

    public function downloadBook(Request $request, $id)
    {
        $book = $this->bookService->resolveByIdOrSlugAnyStatus($id);

        if (!$book || empty($book->book)) {
            return response()->json(['status' => 404, 'message' => 'Book not found']);
        }

        $path = public_path($book->book);

        if (!file_exists($path)) {
            return response()->json(['status' => 404, 'message' => 'Book file not found']);
        }

        return response()->download($path);
    }

    public function viewBook(Request $request, $id)
    {
        $book = $this->bookService->resolveByIdOrSlugAnyStatus($id);

        if (!$book || empty($book->book)) {
            return response()->json(['status' => 404, 'message' => 'Book not found']);
        }

        $path = public_path($book->book);

        if (!file_exists($path)) {
            return response()->json(['status' => 404, 'message' => 'Book file not found']);
        }

        return response()->file($path);
    }
}
