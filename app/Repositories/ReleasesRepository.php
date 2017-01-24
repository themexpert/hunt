<?php

namespace Hunt\Repositories;

use Hunt\Status;
use Hunt\Feature;
use Hunt\Events\FeatureReleased;

class ReleasesRepository
{
    /**
     * Make a new feature suggestion release.
     *
     * @param int   $featureId
     * @param array $status
     */
    public function makeNewRelease($featureId, $status)
    {
        $feature = Feature::with('status')->findOrFail($featureId);

        $feature->status->update([
            'type' => Status::$RELEASED,
            'subject' => $status['subject'],
            'message' => $status['message']
        ]);

        event(new FeatureReleased($feature));
    }
}