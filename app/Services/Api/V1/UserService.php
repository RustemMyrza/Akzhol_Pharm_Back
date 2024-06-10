<?php

namespace App\Services\Api\V1;

use App\Models\User;
use App\Services\FileService;

class UserService
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function update(User $user, array $data)
    {
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone = $data['phone'] ?? null;
        $user->email = $data['email'];

        if (isset($data['photo'])) {
            $user->photo = $this->fileService->saveFile($data['photo'], User::PHOTO_PATH, $user->photo);
        }

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();
        return $user->refresh();
    }
}
