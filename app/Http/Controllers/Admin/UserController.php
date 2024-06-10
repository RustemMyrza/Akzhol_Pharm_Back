<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ExportUserRequest;
use App\Http\Requests\Admin\User\ImportUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class UserController extends Controller
{
    public UserService $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index(Request $request)
    {
        return view('admin.users.index', $this->service->getUsers($request));
    }

    public function create()
    {
        $data['roles'] = User::adminRoles();
        return view('admin.users.create', $data);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $this->service->create($request->validated());
                return redirectPage('admin.users.index', trans('messages.success_created'));
            });
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function show(User $user)
    {
        $data['user'] = $user;
        return view('admin.users.show', $data);
    }

    public function edit(User $user)
    {
        $data['roles'] = User::adminRoles();
        $data['user'] = $user;
        return view('admin.users.edit', $data);
    }

    public function update(User $user, UpdateUserRequest $request)
    {
        try {
            return DB::transaction(function () use ($user, $request) {
                $this->service->update($user, $request->validated());
                return redirectPage('admin.users.index', trans('messages.success_updated'));
            });
        } catch (\Exception $exception) {
            notify()->error('', $exception->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return back()->with('error', trans('messages.error_has_occurred'));
            }

            if ($user->hasRole(['developer'])) {
                return back()->with('error', trans('messages.you_cannot_remove_developer'));
            }

            return DB::transaction(function () use ($user) {
                $this->service->delete($user);
                return redirectPage('admin.users.index', trans('messages.success_deleted'));
            });
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    /**
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public function import(ImportUserRequest $request)
    {
        $fileUsers = (new FastExcel)->import($request->file('document'))->toArray();

        $lineCount = 0;
        $creatingCount = 0;
        $updatingCount = 0;
        $errorsCount = 0;
        $errorRows = [];
        $errorLine = '';

        if (!count($fileUsers)) {
            return backPageError('Файл не успешно импортирован!');
        }

        foreach ($fileUsers as $fileUser) {
            try {
                $findUser = User::query()
                    ->where('email', '=', trim($fileUser['Почта']))
                    ->first();

                if ($findUser) {
                    $findUser->update([
                        'first_name' => trim($fileUser['Имя']),
                        'last_name' => trim($fileUser['Фамилия']),
                        'email' => trim($fileUser['Почта']),
                        'phone' => trim($fileUser['Телефон']) ?? null,
                    ]);
                    $updatingCount++;
                } else {
                    User::query()
                        ->create([
                            'first_name' => trim($fileUser['Имя']),
                            'last_name' => trim($fileUser['Фамилия']),
                            'email' => trim($fileUser['Почта']),
                            'phone' => trim($fileUser['Телефон']) ?? null,
                            'password' => User::DEFAULT_PASSWORD
                        ])
                        ->assignRole(['user']);
                    $creatingCount++;
                }
                unset($findUser);
                unset($fileUser);
                $lineCount++;
            } catch (\Exception $exception) {
                $errorsCount++;
                $errorRows[] = trim($fileUser['Почта']);
                unset($fileUser);
            }
        }

        if (count($errorRows)) {
            $errorLine = implode(', ', $errorRows);
        }

        notify()->success('', trans('messages.success_created'));
        return back()->with([
            'success_import' => trans('messages.success_created'),
            'lineCount' => $lineCount,
            'creatingCount' => $creatingCount,
            'updatingCount' => $updatingCount,
            'errorsCount' => $errorsCount,
            'errorLine' => $errorLine,
        ]);
    }

    public function importExample()
    {
        try {
            return (new FastExcel($this->service->usersLimitGenerator()))
                ->headerStyle($this->service->headerStyles())
                ->rowsStyle($this->service->rowsStyles())
                ->configureOptionsUsing(function ($writer) {
                    $writer->setColumnWidth(16, 1, 2, 4);
                    $writer->setColumnWidth(22, 3);
                })
                ->download('Пример импорт пользователи.xlsx');
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }

    public function export(ExportUserRequest $request)
    {
        try {
            return (new FastExcel($this->service->usersGenerator($request)))
                ->headerStyle($this->service->headerStyles())
                ->rowsStyle($this->service->rowsStyles())
                ->configureOptionsUsing(function ($writer) {
                    $writer->setColumnWidth(15, 2, 3, 5);
                    $writer->setColumnWidth(30, 4);
                })
                ->download('Пользователи.xlsx');
        } catch (\Exception $exception) {
            return back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
