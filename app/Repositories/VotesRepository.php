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

        $userGiveVote = auth()->user()->vote()->withPivot('vote_type')->whereVoteId($featureVote->id)->first();

        if(is_null($userGiveVote)) {

            // update feature vote
            $featureVote->up = $featureVote->up + 1;
            $featureVote->save();

            // save voter
            auth()->user()->vote()->save($featureVote, [
                'vote_type' => 'up'
            ]);
        }

        if(!is_null($userGiveVote) and ($userGiveVote->pivot->vote_type == 'down')) {

            // update feature vote

            if($featureVote->down != 0) {
                $featureVote->down = $featureVote->down - 1;
            } else {
                $featureVote->down = 0;
            }

            $featureVote->up = $featureVote->up + 1;
            $featureVote->save();

            // save voter
            auth()->user()->vote()->updateExistingPivot($featureVote->id, [
                'vote_type' => 'up'
            ]);
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

        $userGiveVote = auth()->user()->vote()->withPivot('vote_type')->whereVoteId($featureVote->id)->first();

        if(is_null($userGiveVote)) {

            // update feature vote
            $featureVote->down = $featureVote->down + 1;
            $featureVote->save();

            // save voter
            auth()->user()->vote()->save($featureVote, [
                'vote_type' => 'down'
            ]);
        }

        if(!is_null($userGiveVote) and ($userGiveVote->pivot->vote_type == 'up')) {

            // update feature vote

            if($featureVote->up != 0) {
                $featureVote->up = $featureVote->up - 1;
            } else {
                $featureVote->up = 0;
            }

            $featureVote->down = $featureVote->down + 1;
            $featureVote->save();

            // save voter
            auth()->user()->vote()->updateExistingPivot($featureVote->id, [
                'vote_type' => 'down'
            ]);
        }
    }
}