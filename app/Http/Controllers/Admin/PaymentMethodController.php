<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\Admin\PaymentMethod\UpdateIsActiveRequest;
use App\Http\Requests\Admin\PaymentMethod\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use App\Services\Admin\PaymentMethod\PaymentMethodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PaymentMethodController extends Controller
{
    public PaymentMethodService $service;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->service = $paymentMethodService;
    }

    public function index()
    {
        try {
            return view('admin.paymentMethods.index', $this->service->getPaymentMethods());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            $data['lastPosition'] = PaymentMethod::lastPosition();
            return view('admin.paymentMethods.create', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StorePaymentMethodRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.paymentMethods.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        try {
            $data['paymentMethod'] = $paymentMethod->load('titleTranslate', 'descriptionTranslate');
            return view('admin.paymentMethods.edit', $data);
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function update(PaymentMethod $paymentMethod, UpdatePaymentMethodRequest $request)
    {
        try {
            return DB::transaction(function () use ($paymentMethod, $request) {
                $this->service->update($paymentMethod, $request->validated());
                return redirectPage('admin.paymentMethods.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            return DB::transaction(function () use ($paymentMethod) {
                $this->service->delete($paymentMethod);
                return redirectPage('admin.paymentMethods.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function updateIsActive(UpdateIsActiveRequest $request): JsonResponse
    {
        try {
            PaymentMethod::query()
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
