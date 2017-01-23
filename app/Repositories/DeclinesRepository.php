<?php

namespace App\Repositories;

use App\Status;
use App\Feature;

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
            'type' => Status::$RELEASED,
            'subject' => $status['subject'],
            'message' => $status['message']
        ]);
    }
}