<?php

namespace Hunt\Repositories;

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
}