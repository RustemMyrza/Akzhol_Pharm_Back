<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Agreement\DeleteAgreementFileRequest;
use App\Http\Requests\Admin\Agreement\StoreAgreementRequest;
use App\Http\Requests\Admin\Agreement\UpdateAgreementRequest;
use App\Models\Agreement;
use App\Services\Admin\Agreement\AgreementService;
use Illuminate\Support\Facades\DB;

class AgreementController extends Controller
{
    public AgreementService $service;

    public function __construct(AgreementService $agreementService)
    {
        $this->service = $agreementService;
    }

    public function index()
    {
        return view('admin.agreements.index', $this->service->getAgreements());
    }

    public function create()
    {
        $data['types'] = Agreement::types();
        return view('admin.agreements.create', $data);
    }

    public function store(StoreAgreementRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.agreements.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function edit(Agreement $agreement)
    {
        $data['types'] = Agreement::types();
        $data['agreement'] = $agreement->load('fileTranslate');
        return view('admin.agreements.edit', $data);
    }

    public function update(UpdateAgreementRequest $request, Agreement $agreement)
    {
        try {
            return DB::transaction(function () use ($request, $agreement) {
                $this->service->update($agreement->load('fileTranslate'), $request->validated());
                return redirectPage('admin.agreements.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Agreement $agreement)
    {
        try {
            return DB::transaction(function () use ($agreement) {
                $this->service->delete($agreement->load('fileTranslate'));
                return redirectPage('admin.agreements.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function deleteFile(Agreement $agreement, DeleteAgreementFileRequest $request)
    {
        try {
            $this->service->deleteFile($agreement->load('fileTranslate'), $request->validated()['language']);
            return back()->with('success', trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
