<?php

namespace App\Services\Admin\NotificationMessage;

use App\Enum\NotificationMessageTypeEnum;
use App\Jobs\NewsLetterJob;
use App\Models\NotificationMessage;
use App\Models\Subscriber;
use App\Services\TranslateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class NotificationMessageService
{
    protected TranslateService $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function getNotificationMessages(Request $request): array
    {
        return [
            'notificationMessages' => NotificationMessage::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->input('search'));

                    foreach ($keywords as $keyword) {
                        $query->where('title', 'like', "%$keyword%")
                            ->orWhere('description', 'like', "%$keyword%");
                    }
                })
                ->latest()
                ->paginate(25)
        ];
    }

    public function create(array $data)
    {
        return NotificationMessage::query()
            ->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'type' => $data['type'],
            ]);
    }

    public function update(NotificationMessage $notificationMessage, array $data)
    {
        $notificationMessage->title = $data['title'];
        $notificationMessage->description = $data['description'];
        $notificationMessage->type = $data['type'];
        return $notificationMessage->save();
    }

    public function delete(NotificationMessage $notificationMessage)
    {
        if (count($notificationMessage->subscriberNotifications)) {
            DB::table('subscriber_notifications')
                ->where('notification_id', '=', $notificationMessage->id)
                ->delete();
        }

        $batch = $notificationMessage->batch();
        if ($batch && $batch->hasFailures()) {
            foreach ($batch->failedJobIds as $failedJobId) {
                DB::table('failed_jobs')
                    ->where('uuid', '=', $failedJobId)
                    ->delete();
            }
            $batch->delete();
        }

        return $notificationMessage->delete();
    }

    public function getDefaultData(object $notificationMessage = null): array
    {
        $data = [
            'types' => NotificationMessageTypeEnum::types()
        ];

        if ($notificationMessage !== null) {
            $data['notificationMessage'] = $notificationMessage;
        }

        return $data;
    }

    public function sendNewsLetters(NotificationMessage $notificationMessage)
    {
        $batch = Bus::batch([])->dispatch();

        $subscribers = Subscriber::query()
            ->where($notificationMessage->type, '=', 1)
            ->isActive()
            ->get();

        foreach ($subscribers as $subscriber) {
            $batch->add(new NewsLetterJob($subscriber, $notificationMessage));
        }

        return $notificationMessage
            ->update([
                'batch_id' => $batch->id,
                'status' => 1
            ]);
    }

    /**
     * @throws \Exception
     */
    public function retryFailedJobs(NotificationMessage $notificationMessage)
    {
        $batch = $notificationMessage->batch();

        if ($batch && $batch->hasFailures()) {
            if (!count($batch->failedJobIds)){
                throw new \Exception('Ошибки не найдены! Все успешно отправлены!');
            }

            foreach ($batch->failedJobIds as $failedJobId) {
                Artisan::call('queue:retry', ['id' => $failedJobId]);
            }
        }
        return true;
    }
}
