<?php

namespace Hunt\Repositories;

use Hunt\Status;
use Hunt\Feature;

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

        $feature->status->update([
            'type' => Status::$DECLINE,
            'subject' => $status['subject'],
            'message' => $status['message']
        ]);
    }
}