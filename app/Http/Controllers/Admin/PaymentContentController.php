<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentContent\StorePaymentContentRequest;
use App\Http\Requests\Admin\PaymentContent\UpdatePaymentContentRequest;
use App\Models\Payment;
use App\Models\PaymentContent;
use App\Services\Admin\PaymentContent\PaymentContentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PaymentContentController extends Controller
{
    public PaymentContentService $service;

    public function __construct(PaymentContentService $paymentContentService)
    {
        $this->service = $paymentContentService;
    }

    public function index()
    {
        try {
            $data['paymentContent'] = $this->service->getPaymentContents();
            return view('admin.paymentContent.index', $this->service->getPaymentContents());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.paymentContent.create');
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StorePaymentContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.paymentContent.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(PaymentContent $paymentContent)
    {
        try {
            $data['paymentContent'] = $paymentContent->load('descriptionTranslate', 'contentTranslate');
            return view('admin.paymentContent.edit', $data);
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(PaymentContent $paymentContent, UpdatePaymentContentRequest $request)
    {
        try {
            return DB::transaction(function () use ($paymentContent, $request) {
                $this->service->update($paymentContent, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function deleteImage(PaymentContent $paymentContent)
    {
        try {
            $this->service->deleteImage($paymentContent);
            notify()->success('', trans('messages.success_deleted'));
            return new JsonResource(['status' => true]);
        } catch (\Exception $exception) {
            return new JsonResource(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}
