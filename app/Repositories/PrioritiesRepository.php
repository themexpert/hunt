<?php

namespace Hunt\Repositories;

use Hunt\Priority;

class PrioritiesRepository
{
    /**
     * Update suggested feature priority value.
     *
     * @param int $featureId
     * @param int $value
     */
    public function update($featureId, $value)
    {
        $priority = Priority::whereUserId(auth('api')->user()->id)
                            ->whereFeatureId($featureId)
                            ->first();

        if(!is_null($priority)) {
            $priority->value = $value;

            $priority->save();
        }
    }
}