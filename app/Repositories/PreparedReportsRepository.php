<?php

namespace App\Repositories;

use DB;
use App\Vote;
use Exception;
use App\Priority;

class PreparedReportsRepository
{
    /**
     * Prepared reports by type
     *
     * @param string $type
     * @return \App\Feature
     */
    public function byType($type)
    {
        $type = str_replace('-', '', $type);

        return $this->{$type}();
    }

    /**
     * Get popular feature suggestion based on user vote.
     *
     * @return \App\Vote
     */
    protected function popularVote()
    {
        return Vote::with('feature')->orderBy('up')->get();
    }

    /**
     * Get low popular feature suggestion based on user vote.
     *
     * @return \App\Vote
     */
    protected function lowPopularVote()
    {
        return Vote::with('feature')->orderBy('down')->get();
    }

    /**
     * Get high value feature suggestion based on user priority.
     *
     * @return \App\Vote
     */
    protected function highValue()
    {
        return Priority::with('feature')
            ->select('id', 'user_id', 'feature_id', DB::raw('sum(value) as value'))
            ->groupBy('feature_id')
            ->orderBy('value', 'desc')
            ->get();
    }

    /**
     * Get low value feature suggestion based on user priority.
     *
     * @return \App\Vote
     */
    protected function lowValue()
    {
        return Priority::with('feature')
            ->select('id', 'user_id', 'feature_id', DB::raw('sum(value) as value'))
            ->groupBy('feature_id')
            ->orderBy('value')
            ->get();
    }

    /**
     * Get mid value feature suggestion based on user priority.
     *
     * @return \App\Vote
     */
    protected function midValue()
    {
        return Priority::with('feature')
            ->select('id', 'user_id', 'feature_id', DB::raw('sum(value) as value'))
            ->groupBy('feature_id')
            ->orderBy('value')
            ->where('value', '>=', 30)
            ->where('value', '<=', 70)
            ->get();
    }

    /**
     * Get suggested features based on development effort vs value.
     *
     * @return mixed
     */
    protected function effortVsValue()
    {
        $effortDefaultSearchValue = 100;

        if(!empty(request()->input('value'))) {
            $effortDefaultSearchValue = request()->input('value');
        }

        return DB::table('features')
                ->join('statuses', 'features.id', '=', 'statuses.feature_id')
                ->join('priorities', 'features.id', '=', 'priorities.feature_id')
                ->join('efforts', 'features.id', '=', 'efforts.feature_id')
                ->select(
                    'features.id',
                    'features.name',
                    'statuses.type',
                    'efforts.value as effort_vlaue',
                    'priorities.value as priority_value'
                )
                ->groupBy('features.name')
                ->where('efforts.value', '<=', $effortDefaultSearchValue)
                ->get();
    }

    /**
     * Throw an exception if requested method does not exist.
     *
     * @param string $name
     * @param array $arguments
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        throw new Exception("Please, implement [$name] method");
    }
}