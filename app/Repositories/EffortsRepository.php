<?php

namespace Hunt\Repositories;

use Hunt\Effort;

class EffortsRepository
{
    /**
     * Update suggested feature development effort value.
     *
     * @param int $featureId
     * @param int $value
     */
    public function update($featureId, $value)
    {
        $effort = Effort::whereUserId(auth()->user()->id)
                            ->whereFeatureId($featureId)
                            ->first();

        if(!is_null($effort)) {
            $effort->value = $value;

            $effort->save();
        }
    }
}