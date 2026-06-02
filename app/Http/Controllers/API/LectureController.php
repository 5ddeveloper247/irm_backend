<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AudioCategory;
use App\Models\AudioLecture;
use App\Services\AudioLectureService;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function __construct(private AudioLectureService $audioLectureService)
    {
    }

    public function getLectures(Request $request, $categoryId = 0)
    {
        $search = $request->query('search');

        $query = AudioLecture::with(['category', 'attachments'])
            ->where('status', 1);

        if ($categoryId != 0) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('speaker', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $lectureList = $query->orderByDesc('id')
            ->get()
            ->map(fn ($lecture) => $this->audioLectureService->formatLectureForApi($lecture));

        $categoryList = AudioCategory::where('status', 1)
            ->orderByDesc('id')
            ->get()
            ->map(fn ($category) => $this->audioLectureService->formatCategoryForApi($category));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'lecture_list' => $lectureList,
                'category_list' => $categoryList,
            ],
        ]);
    }

    public function getSpecificLecture(Request $request, $id)
    {
        $lecture = AudioLecture::with(['category', 'attachments'])
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$lecture) {
            return response()->json(['status' => 404, 'message' => 'Audio lecture not found']);
        }

        $relatedLectures = AudioLecture::with(['category', 'attachments'])
            ->where('status', 1)
            ->where('category_id', $lecture->category_id)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(3)
            ->get()
            ->map(fn ($item) => $this->audioLectureService->formatLectureForApi($item));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => [
                'lecture_detail' => $this->audioLectureService->formatLectureForApi($lecture),
                'related_lectures' => $relatedLectures,
            ],
        ]);
    }

    public function getCategory(Request $request)
    {
        $categoryList = AudioCategory::where('status', 1)
            ->orderByDesc('id')
            ->get()
            ->map(fn ($category) => $this->audioLectureService->formatCategoryForApi($category));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => ['category_list' => $categoryList],
        ]);
    }

    public function getAudioCategoriesWithAudioLectures(Request $request)
    {
        $limit = (int) $request->query('per_category', 2);
        $categoryLimit = (int) $request->query('category_limit', 0);

        $query = AudioCategory::where('status', 1)->orderByDesc('id');

        if ($categoryLimit > 0) {
            $query->limit($categoryLimit);
        }

        $categories = $query->get()
            ->map(fn ($category) => $this->audioLectureService->formatCategoryForApi($category, true, $limit));

        return response()->json([
            'status' => 200,
            'message' => '',
            'data' => ['category_list' => $categories],
        ]);
    }
}
