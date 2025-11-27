<?php

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;
class JournalPolicy
{
    public function view(User $user, Journal $journal)
    {
        return $journal->user_id === $user->id;
    }
    public function update(User $user, Journal $journal)
    {
        return $journal->user_id === $user->id;
    }
    public function delete(User $user, Journal $journal)
    {
        return $journal->user_id === $user->id;
    }
}
