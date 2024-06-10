<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationMessage\StoreNotificationMessageRequest;
use App\Http\Requests\Admin\NotificationMessage\UpdateNotificationMessageRequest;
use App\Models\NotificationMessage;
use App\Services\Admin\NotificationMessage\NotificationMessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationMessageController extends Controller
{
    public NotificationMessageService $service;

    public function __construct(NotificationMessageService $notificationMessageService)
    {
        $this->service = $notificationMessageService;
    }

    public function index(Request $request)
    {
        try {
            return view('admin.notificationMessages.index', $this->service->getNotificationMessages($request));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.notificationMessages.create', $this->service->getDefaultData());
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function store(StoreNotificationMessageRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.notificationMessages.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function show(NotificationMessage $notificationMessage)
    {
        try {
            return view('admin.notificationMessages.show', $this->service->getDefaultData($notificationMessage));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function edit(NotificationMessage $notificationMessage)
    {
        try {
            return view('admin.notificationMessages.edit', $this->service->getDefaultData($notificationMessage));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function update(NotificationMessage $notificationMessage, UpdateNotificationMessageRequest $request)
    {
        try {
            return DB::transaction(function () use ($notificationMessage, $request) {
                $this->service->update($notificationMessage, $request->validated());
                return backPage(trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function destroy(NotificationMessage $notificationMessage)
    {
        try {
            return DB::transaction(function () use ($notificationMessage) {
                $this->service->delete($notificationMessage);
                return backPage(trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function sendMessages(NotificationMessage $notificationMessage)
    {
        try {
            $this->service->sendNewsLetters($notificationMessage);
            return backPage(trans('messages.success_created'));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }

    public function retrySendMessages(NotificationMessage $notificationMessage)
    {
        try {
            $this->service->retryFailedJobs($notificationMessage);
            return back()->with('success', trans('messages.success_created'));
        } catch (\Exception $exception) {
            return backPageError($exception->getMessage());
        }
    }
}
