<?php

namespace App\Services\Admin\Application;

use App\Enum\ApplicationEnum;
use App\Http\Requests\Admin\Application\ExportApplicationRequest;
use App\Models\Application;
use App\Services\Admin\Service;
use Illuminate\Http\Request;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;

class ApplicationService extends Service
{
    public function getApplications(Request $request): array
    {
        return [
            'statuses' => ApplicationEnum::statuses(),
            'applications' => Application::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->input('search'));

                    $query->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subQuery->where('phone', 'like', "%$keyword%")
                                ->orWhere('name', 'like', "%$keyword%")
                                ->orWhere('message', 'like', "%$keyword%")
                                ->orWhere('email', 'like', "%$keyword%");
                        }
                    });
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', '=', $request->input('status'));
                })
                ->latest()
                ->paginate(20)
        ];
    }

    public function applicationsGenerator(ExportApplicationRequest $request)
    {
        $applications = Application::query()
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', '=', $request->input('status'));
            })
            ->latest()
            ->get();

        foreach ($applications as $application) {
            yield [
                'ID' => $application->id,
                'Имя' => $application->name,
                'Телефон' => $application->phone ?? '-',
                'Почта' => $application->email,
                'Сообщения' => $application->message,
                'Время' => $application->time_format,
                'Статус' => $application->status_name,
            ];
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function headerStyles()
    {
        return (new Style())
            ->setFontSize(11)
            ->setCellAlignment('left')
            ->setShouldWrapText(false)
            ->setFontBold();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function rowsStyles()
    {
        return (new Style())
            ->setFontSize(11)
            ->setCellAlignment('left')
            ->setShouldWrapText(false);
    }
}
