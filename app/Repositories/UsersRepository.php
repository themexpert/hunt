<?php

namespace Hunt\Repositories;

use Hunt\User;
use Hunt\Feature;

class UsersRepository
{
    /**
     * Get suggested features related to the given user id.
     *
     * @param int $userId
     * @return \Hunt\Feature
     */
    public function suggests($userId)
    {
        return Feature::whereUserId($userId)->get();
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get()
    {
        return User::all();
    }
}