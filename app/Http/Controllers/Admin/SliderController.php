<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\StoreSliderRequest;
use App\Http\Requests\Admin\Slider\UpdateIsActiveRequest;
use App\Http\Requests\Admin\Slider\UpdateSliderRequest;
use App\Models\Slider;
use App\Services\Admin\Slider\SliderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    public SliderService $service;

    public function __construct(SliderService $sliderService)
    {
        $this->service = $sliderService;
    }

    public function index()
    {
        $data['sliders'] = $this->service->getSliders();
        return view('admin.sliders.index', $data);
    }

    public function create()
    {
        $data['lastPosition'] = Slider::lastPosition();
        return view('admin.sliders.create', $data);
    }

    public function store(StoreSliderRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.sliders.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Slider $slider)
    {
        $data['slider'] = $slider->load('titleTranslate', 'descriptionTranslate');
        return view('admin.sliders.edit', $data);
    }

    public function update(Slider $slider, UpdateSliderRequest $request)
    {
        try {
            return DB::transaction(function () use ($slider, $request) {
                $this->service->update($slider, $request->validated());
                return redirectPage('admin.sliders.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Slider $slider)
    {
        try {
            return DB::transaction(function () use ($slider) {
                $this->service->delete($slider);
                return redirectPage('admin.sliders.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Slider::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
