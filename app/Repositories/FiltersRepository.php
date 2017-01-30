<?php

namespace Hunt\Repositories;

use Hunt\Tag;
use Hunt\Feature;

class FiltersRepository
{
    /**
     * Filter suggested features by access.
     *
     * @param string $filterBy
     * @return \Hunt\Feature
     */
    public function byAccess($filterBy)
    {
        if(strtolower($filterBy) == 'any') {
            return Feature::with(['product', 'tags', 'status', 'vote'])
                ->get();
        }

        return Feature::with(['product', 'tags', 'status', 'vote'])
            ->whereIsPublic($this->getAccessValue($filterBy))
            ->get();
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
     * @param int $tagId
     * @return \Hunt\Feature
     */
    public function byTag($tagId)
    {
        if($tagId == 0) {
            return Tag::with(['product', 'tags', 'status', 'vote'])->get();
        }

        return Tag::findOrFail($tagId)->features()
            ->with(['product', 'tags', 'status', 'vote'])
            ->get();
    }
}