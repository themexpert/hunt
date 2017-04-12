<?php

namespace Hunt\Repositories;

use Hunt\Status;
use Hunt\Feature;
use Hunt\Events\FeatureStatusUpdated;

class DeclinesRepository
{
    /**
     * Decline an existing feature.
     *
     * @param int   $featureId
     * @param array $status
     */
    public function declineFeature($featureId, $status)
    {
        $feature = Feature::with('status')->findOrFail($featureId);

        $updatedStatus = [
            'type' => Status::$DECLINED,
            'subject' => $status['subject'],
            'message' => $status['message']
        ];

        $feature->status->update($updatedStatus);

        event(new FeatureStatusUpdated($feature, $updatedStatus));
    }
}