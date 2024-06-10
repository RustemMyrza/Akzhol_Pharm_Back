<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutUsContent\StoreAboutUsContentRequest;
use App\Http\Requests\Admin\AboutUsContent\UpdateAboutUsContentRequest;
use App\Models\AboutUsContent;
use App\Services\Admin\AboutUsContent\AboutUsContentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AboutUsContentController extends Controller
{
    public AboutUsContentService $service;

    public function __construct(AboutUsContentService $aboutUsContentService)
    {
        $this->service = $aboutUsContentService;
    }

    public function index()
    {
        try {
            $data['aboutUsContent'] = $this->service->getAboutUsContent();
            if ($data['aboutUsContent'])
                return redirect()->route('admin.aboutUsContents.edit', $data['aboutUsContent']);
            else
                return view('admin.aboutUsContents.index', $this->service->getAboutUsContents());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.aboutUsContents.create');
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreAboutUsContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.aboutUsContents.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(AboutUsContent $aboutUsContent)
    {
        try {
            $data['aboutUsContent'] = $aboutUsContent->load('descriptionTranslate', 'contentTranslate');
            return view('admin.aboutUsContents.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(AboutUsContent $aboutUsContent, UpdateAboutUsContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($aboutUsContent, $request) {
                $this->service->update($aboutUsContent, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function deleteImage(AboutUsContent $aboutUsContent)
    {
        try {
            $this->service->deleteImage($aboutUsContent);
            notify()->success('', trans('messages.success_deleted'));
            return new JsonResource(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResource(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}
