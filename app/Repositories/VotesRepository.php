<?php

namespace Hunt\Repositories;

use Hunt\Vote;
use Hunt\Feature;

class VotesRepository
{
    /**
     * Save up vote.
     *
     * @param int $id
     */
    public function up($id)
    {
        $feature = Feature::findOrFail($id);

        $featureVote = Vote::whereFeatureId($feature->id)->first();

        $featureVote->up = $featureVote->up + 1;

        $featureVote->save();
    }

    /**
     * Save down vote.
     *
     * @param int $id
     */
    public function down($id)
    {
        $feature = Feature::findOrFail($id);

        $featureVote = Vote::whereFeatureId($feature->id)->first();

        $featureVote->up = $featureVote->up - 1;

        if($featureVote->down < 0) {
            $featureVote->down = 0;
        }

        $featureVote->save();
    }
}