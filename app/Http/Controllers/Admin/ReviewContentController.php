<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewContent\StoreReviewContentRequest;
use App\Http\Requests\Admin\ReviewContent\UpdateReviewContentRequest;
use App\Models\ReviewsContent;
use App\Services\Admin\ReviewContent\ReviewContentService;
use Illuminate\Support\Facades\DB;

class ReviewContentController extends Controller
{
    public ReviewContentService $service;

    public function __construct(ReviewContentService $reviewContentService)
    {
        $this->service = $reviewContentService;
    }

    public function index()
    {
        try {
            return view('admin.reviewContent.index', $this->service->getReviewContents());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.reviewContent.create');
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreReviewContentRequest $request)
    {
        // return $request->all();
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.reviewContent.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function newEdit ()
    {
        $reviewContent = ReviewsContent::query()->with([
            'titleTranslate',
            'descriptionTranslate'
        ])->get();
        return view('admin.reviewContent.edit', $reviewContent);
        return $reviewContent;
    }

    public function edit(ReviewsContent $reviewContent)
    {
        try {
            $data['reviewContent'] = $reviewContent->load('descriptionTranslate');
            return view('admin.reviewContent.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(ReviewsContent $reviewContent, UpdateReviewContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($reviewContent, $request) {
                $this->service->update($reviewContent, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
