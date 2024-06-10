<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Social\StoreSocialRequest;
use App\Http\Requests\Admin\Social\UpdateIsActiveRequest;
use App\Http\Requests\Admin\Social\UpdateSocialRequest;
use App\Models\Social;
use App\Services\Admin\Social\SocialService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SocialController extends Controller
{
    public SocialService $service;

    public function __construct(SocialService $socialService)
    {
        $this->service = $socialService;
    }

    public function index()
    {
        $data['socials'] = Social::query()->get();
        return view('admin.socials.index', $data);
    }

    public function create()
    {
        return view('admin.socials.create');
    }

    public function store(StoreSocialRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirectPage('admin.socials.index', trans('messages.success_created'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Social $social)
    {
        return view('admin.socials.edit', ['social' => $social]);
    }

    public function update(Social $social, UpdateSocialRequest $request)
    {
        try {
            $this->service->update($social, $request->validated());
            return redirectPage('admin.socials.index', trans('messages.success_updated'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Social $social)
    {
        try {
            $this->service->delete($social);
            return redirectPage('admin.socials.index', trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            Social::query()
                ->find($request->input('data_id'))
                ->update([
                    'is_active' => $request->input('is_active') == 1 ? 1 : 0
                ]);
            return new JsonResponse(['status' => true], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse(['status' => false, 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
