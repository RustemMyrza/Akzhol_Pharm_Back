<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ApplicationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Application\ExportApplicationRequest;
use App\Http\Requests\Admin\Application\StoreApplicationRequest;
use App\Http\Requests\Admin\Application\UpdateApplicationRequest;
use App\Models\Application;
use App\Services\Admin\Application\ApplicationService;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ApplicationController extends Controller
{
    public ApplicationService $service;

    public function __construct(ApplicationService $applicationService)
    {
        $this->service = $applicationService;
    }

    public function index(Request $request)
    {
        return view('admin.applications.index', $this->service->getApplications($request));
    }

    public function create()
    {
        $data['statuses'] = ApplicationEnum::statuses();
        return view('admin.applications.create', $data);
    }

    public function store(StoreApplicationRequest $request)
    {
        try {
            Application::query()->create($request->validated());
            return redirectPage('admin.applications.index', trans('messages.success_created'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function show(Application $application)
    {
        return view('admin.applications.show', ['application' => $application]);
    }

    public function edit(Application $application)
    {
        $data['statuses'] = ApplicationEnum::statuses();
        $data['application'] = $application;
        return view('admin.applications.edit', $data);
    }

    public function update(Application $application, UpdateApplicationRequest $request)
    {
        try {
            $application->update($request->validated());
            return redirectPage('admin.applications.index', trans('messages.success_updated'));
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(Application $application)
    {
        try {
            $application->delete();
            return redirectPage('admin.applications.index', trans('messages.success_deleted'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    public function export(ExportApplicationRequest $request)
    {
        try {
            return (new FastExcel($this->service->applicationsGenerator($request)))
                ->headerStyle($this->service->headerStyles())
                ->rowsStyle($this->service->rowsStyles())
                ->configureOptionsUsing(function ($writer) {
                    $writer->setColumnWidth(18, 2, 3, 6, 7);
                    $writer->setColumnWidth(22, 4, 5);
                })
                ->download('Обратной связи.xlsx');
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
