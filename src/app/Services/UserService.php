<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function list(int $userId): Collection
    {
        return User::query()
            ->whereNot('id', $userId)
            ->get();
    }
}
