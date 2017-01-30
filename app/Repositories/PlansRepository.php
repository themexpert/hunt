<?php

namespace Hunt\Repositories;

use Hunt\Status;
use Hunt\Feature;

class PlansRepository
{
    /**
     * Plan to implement an existing feature.
     *
     * @param int   $featureId
     * @param array $status
     */
    public function planFeature($featureId, $status)
    {
        $feature = Feature::with('status')->findOrFail($featureId);

        $feature->status->update([
            'type' => Status::$IN_PROGRESS,
            'subject' => $status['subject'],
            'message' => $status['message']
        ]);
    }
}