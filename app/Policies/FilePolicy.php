<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
    public function viewAny(?User $user): bool
    {
        return $user !== null;
    }

    public function create(?User $user): bool
    {
        return $user !== null;
    }

    public function view(?User $user, File $file): bool
    {
        return $user !== null && $user->id === $file->user_id;
    }

    public function update(?User $user, File $file): bool
    {
        return $user !== null && $user->id === $file->user_id;
    }

    public function delete(?User $user, File $file): bool
    {
        return $user !== null && $user->id === $file->user_id;
    }
}
