<?php

namespace App\Services\Admin\User;

use App\Http\Requests\Admin\User\ExportUserRequest;
use App\Models\User;
use App\Services\Admin\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;

class UserService extends Service
{
    public function getUsers(Request $request): array
    {
        return [
            'roles' => User::adminRoles(),
            'users' => User::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $keywords = explode(' ', $request->input('search'));

                    $query->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subQuery->where('id', 'like', "%$keyword%")
                                ->orWhere('first_name', 'like', "%$keyword%")
                                ->orWhere('last_name', 'like', "%$keyword%")
                                ->orWhere('phone', 'like', "%$keyword%")
                                ->orWhere('email', 'like', "%$keyword%");
                        }
                    });
                })
                ->with('roles')
                ->whereHas("roles", function ($query) {
                    $query->whereIn("name", User::getRolesForUser());
                })
                ->orderBy('id')
                ->paginate(20)
        ];
    }

    public function create(array $data)
    {
        return User::query()
            ->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'photo' => isset($data['photo']) ? $this->fileService->saveFile($data['photo'], User::PHOTO_PATH) : null,
            ])
            ->assignRole($data['role']);
    }

    public function update(User $user, array $data)
    {
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];

        if (isset($data['photo'])) {
            $user->photo = $this->fileService->saveFile($data['photo'], User::PHOTO_PATH, $user->photo);
        }

        $user->syncRoles($data['role']);

        if ($data['password']) {
            $user->password = $data['password'];
            $user->remember_token = null;

            DB::table('sessions')->where('user_id', '=', $user->id)->delete();
        }

        return $user->save();
    }

    public function delete(User $user)
    {
        $user->syncRoles([]);
        if ($user->photo) {
            $this->fileService->deleteFile($user->photo, User::PHOTO_PATH);
        }
        return $user->delete();
    }

    public function usersGenerator(ExportUserRequest $request)
    {
        $users = User::query()
            ->whereDoesntHave('roles', function ($subQuery) {
                $subQuery->where('name', '=', 'developer');
            })
            ->when($request->filled('role'), function ($query) use ($request) {
                $role = $request->input('role');

                $query->whereHas('roles', function ($subQuery) use ($role) {
                    $subQuery->where('name', '=', $role);
                });
            })
            ->get();

        foreach ($users as $user) {
            yield [
                'ID' => $user->id,
                'Имя' => $user->first_name,
                'Фамилия' => $user->last_name,
                'Почта' => $user->email,
                'Телефон' => $user->phone ?? '-',
                'Дата регистрации' => $user->created_at_format
            ];
        }
    }

    public function usersLimitGenerator(int $limit = 5)
    {
        $users = User::query()
            ->whereDoesntHave('roles', function ($subQuery) {
                $subQuery->where('name', '=', 'developer');
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        foreach ($users as $user) {
            yield [
                'Имя' => $user->first_name,
                'Фамилия' => $user->last_name,
                'Почта' => $user->email,
                'Телефон' => $user->phone,
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
