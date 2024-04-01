<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{


    public function view(?User $user, user $model): bool
    {
        return !($model->user_type == 'C');
    }


    public function update(User $user, user $model): bool
    {
        return !($model->user_type == 'C');
    }

}
