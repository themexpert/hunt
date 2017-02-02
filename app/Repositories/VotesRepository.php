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

        $userGiveVote = auth()->user()->vote()->whereVoteId($featureVote->id)->first();

        if(is_null($userGiveVote)) {

            // update feature vote
            $featureVote->up = $featureVote->up + 1;
            $featureVote->save();

            // save voter
            auth()->user()->vote()->save($featureVote);
        }
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

        $userGiveVote = auth()->user()->vote()->whereVoteId($featureVote->id)->first();

        if(is_null($userGiveVote)) {

            // update feature vote
            $featureVote->down = $featureVote->down + 1;
            $featureVote->save();

            // save voter
            auth()->user()->vote()->save($featureVote);
        }
    }
}