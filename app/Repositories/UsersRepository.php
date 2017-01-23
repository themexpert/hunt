<?php

namespace App\Repositories;

use App\Feature;

class UsersRepository
{
    /**
     * Get suggested features related to the given user id.
     *
     * @param int $userId
     * @return \App\Feature
     */
    public function suggests($userId)
    {
        return Feature::whereUserId($userId)->get();
    }
}