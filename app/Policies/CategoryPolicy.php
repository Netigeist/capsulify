<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(?User $user): bool
    {
        return $user !== null;
    }

    public function create(?User $user): bool
    {
        return $user !== null;
    }

    public function view(?User $user, Category $category): bool
    {
        return $user !== null && $user->id === $category->user_id;
    }

    public function update(?User $user, Category $category): bool
    {
        return $user !== null && $user->id === $category->user_id;
    }

    public function delete(?User $user, Category $category): bool
    {
        return $user !== null && $user->id === $category->user_id;
    }
}
