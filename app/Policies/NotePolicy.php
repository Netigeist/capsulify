<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    public function viewAny(?User $user): bool
    {
        return $user !== null;
    }

    public function create(?User $user): bool
    {
        return $user !== null;
    }

    public function view(?User $user, Note $note): bool
    {
        return $user !== null && $user->id === $note->user_id;
    }

    public function update(?User $user, Note $note): bool
    {
        return $user !== null && $user->id === $note->user_id;
    }

    public function delete(?User $user, Note $note): bool
    {
        return $user !== null && $user->id === $note->user_id;
    }
}
