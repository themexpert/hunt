<?php

namespace Hunt\Repositories;

use DB;
use Hunt\Vote;
use Exception;
use Hunt\Priority;
use Hunt\Concerns\DataWithPagination;

class PreparedReportsRepository
{
    use DataWithPagination;

    /**
     * Prepared reports by type.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @param string $type
     * @return array
     */
    public function byType($limit = 10, $searchTerms = '', $status = '', $type)
    {
        $type = camel_case($type);

        return $this->{$type}($limit, $searchTerms, $status);
    }

    /**
     * Get popular feature suggestion based on user vote.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @return array
     */
    public function popularVote($limit = 10, $searchTerms = '', $status = '')
    {
        $features = Vote::with(['feature', 'feature.product', 'feature.priority'])->orderBy('up');

        return $this->dataWithPagination($features, $limit, 'desc', 'id');
    }

    /**
     * Get popular feature suggestion based on user vote.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @return array
     */
    public function lowPopularVote($limit = 10, $searchTerms = '', $status = '')
    {
        $features = Vote::with(['feature', 'feature.product', 'feature.priority'])->orderBy('down');

        return $this->dataWithPagination($features, $limit, 'desc', 'id');
    }

    /**
     * Get high value feature suggestion based on user priority.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @return array
     */
    public function highValue($limit = 10, $searchTerms = '', $status = '')
    {
        $features = Priority::with(['feature', 'feature.product', 'feature.priority'])
            ->select('id', 'user_id', 'feature_id', DB::raw('sum(value) as value'))
            ->groupBy('id', 'feature_id')
            ->orderBy('value', 'desc');

        return $this->dataWithPagination($features, $limit, 'desc', 'id');
    }

    /**
     * Get low value feature suggestion based on user priority.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @return array
     */
    public function lowValue($limit = 10, $searchTerms = '', $status = '')
    {
        $features = Priority::with(['feature', 'feature.product', 'feature.priority'])
            ->select('id', 'user_id', 'feature_id', DB::raw('sum(value) as value'))
            ->groupBy('id', 'feature_id')
            ->orderBy('value');

        return $this->dataWithPagination($features, $limit, 'desc', 'id');
    }

    /**
     * Get mid value feature suggestion based on user priority.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @return array
     */
    public function midValue($limit = 10, $searchTerms = '', $status = '')
    {
        $features = Priority::with(['feature', 'feature.product', 'feature.priority'])
            ->select('id', 'user_id', 'feature_id', DB::raw('sum(value) as value'))
            ->groupBy('id', 'feature_id')
            ->orderBy('value')
            ->where('value', '>=', 30)
            ->where('value', '<=', 70);

        return $this->dataWithPagination($features, $limit, 'desc', 'id');
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
                ->join('products', 'products.id', '=', 'features.product_id')
                ->join('statuses', 'features.id', '=', 'statuses.feature_id')
                ->join('priorities', 'features.id', '=', 'priorities.feature_id')
                ->join('efforts', 'features.id', '=', 'efforts.feature_id')
                ->select(
                    'features.id',
                    'features.name as feature_name',
                    'products.name as product_name',
                    'statuses.type as status_type',
                    'efforts.value as effort_value',
                    'priorities.value as priority_value'
                )
                ->groupBy('features.id', 'feature_name', 'product_name', 'status_type', 'effort_value', 'priority_value')
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