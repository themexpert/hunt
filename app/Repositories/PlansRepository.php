<?php

namespace Hunt\Repositories;

use Hunt\Status;
use Hunt\Feature;
use Hunt\Events\FeatureStatusUpdated;

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

        $updatedStatus = [
            'type' => Status::$IN_PROGRESS,
            'subject' => $status['subject'],
            'message' => $status['message']
        ];

        $feature->status->update($updatedStatus);

        event(new FeatureStatusUpdated($feature, $updatedStatus));
    }
}