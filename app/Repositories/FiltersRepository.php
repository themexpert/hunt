<?php

namespace Hunt\Repositories;

use Hunt\Tag;
use Hunt\Feature;
use Hunt\Concerns\DataWithPagination;

class FiltersRepository
{
    use DataWithPagination;

    /**
     * Filter suggested features by access.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @param string $filterBy
     * @return array
     */
    public function byAccess($limit = 10, $searchTerms = '', $status = '', $filterBy)
    {
        $features = null;

        if(strtolower($filterBy) == 'any') {
            $features = Feature::with(['product', 'priority', 'tags', 'status', 'vote']);
        } else {
            $features = Feature::with(['product', 'priority', 'tags', 'status', 'vote'])
                ->whereIsPublic($this->getAccessValue($filterBy));
        }

        return $this->dataWithPagination($features, $limit, 'desc', 'features.id');
    }

    /**
     * Get access value from the given filter value.
     *
     * @param string $filterBy
     * @return int
     */
    protected function getAccessValue($filterBy)
    {
        if(strtolower($filterBy) == 'public') return 1;

        return 0;
    }

    /**
     * Filter suggested features by tag.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param string $status
     * @param int    $tagId
     * @return array
     */
    public function byTag($limit = 10, $searchTerms = '', $status = '', $tagId)
    {
        $tags = null;

        if($tagId == 0) {
            $tags = Tag::with(['product', 'priority', 'tags', 'status', 'vote']);
        } else {
            $tags = Tag::findOrFail($tagId)->features()
                ->with(['product', 'priority', 'tags', 'status', 'vote']);
        }

        return $this->dataWithPagination($tags, $limit, 'desc', 'id');
    }
}