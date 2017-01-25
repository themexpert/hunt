<?php

namespace Hunt\Repositories;

use Hunt\Tag;
use Hunt\Vote;
use Hunt\Status;
use Hunt\Effort;
use Hunt\Feature;
use Hunt\Priority;
use Hunt\Concerns\DataWithPagination;
use Hunt\Events\FeatureStatusUpdated;

class FeaturesRepository
{
    use DataWithPagination;

    /**
     * Add a new feature suggest.
     *
     * @param int     $productId
     * @param string  $name
     * @param string  $description
     * @param boolean $isPrivate
     * @param array   $tags
     * @return \Hunt\Feature
     */
    public function add($productId, $name, $description, $isPrivate, $tags)
    {
        $feature = Feature::create([
            'user_id' => auth()->user()->id,
            'product_id' => $productId,
            'name' => $name,
            'description' => $description,
            'is_public' => $this->getSuggestionStatus($isPrivate)
        ]);

        $this->attachTags($tags, $feature);

        $this->setDefaultStatus($feature);

        $this->createVote($feature);

        $this->setPriorityDefaultValue($feature);

        $this->setEffortDefaultValue($feature);

        return $feature;
    }

    /**
     * Get suggestion status from the given value.
     *
     * @param boolean $isPrivate
     * @return int
     */
    private function getSuggestionStatus($isPrivate)
    {
        return ( empty($isPrivate) and ($isPrivate == true) )
            ? 0
            : 1;
    }

    /**
     * Get feature suggestions.
     *
     * @param int    $limit
     * @param string $searchTerms
     * @param int    $productId
     * @return array
     */
    public function get($limit = 10, $searchTerms = '', $productId)
    {
        $features = null;

        if(! empty($searchTerms)) {
            $features = Feature::with(['tags', 'status', 'vote'])
                                ->where("product_id", "=", $productId)
                                ->orWhere("name", "like", "%$searchTerms%")
                                ->orWhere("description", "like", "%$searchTerms%");
        } else {
            $features = Feature::with(['tags', 'status', 'vote'])
                                ->where("product_id", "=", $productId);
        }

        return $this->dataWithPagination($features, $limit);
    }

    /**
     * Remove feature suggestion.
     *
     * @param int $productId
     * @param int $id
     */
    public function remove($productId, $id)
    {
        Feature::findOrFail($id)->delete();
    }

    /**
     * Update an existing feature suggestion.
     *
     * @param int     $id
     * @param string  $name
     * @param string  $description
     * @param boolean $isPrivate
     * @param array   $tags
     * @param array   $status
     */
    public function update($id, $name, $description, $isPrivate, $tags, $status)
    {
        $feature = Feature::findOrFail($id);

        $feature->update([
            'name' => $name,
            'description' => $description,
            'is_public' => $this->getSuggestionStatus($isPrivate)
        ]);

        $feature->tags()->detach();

        $this->attachTags($tags, $feature);

        $this->updateStatus($feature, $status);
    }

    /**
     * Attach tags with the given suggested feature.
     *
     * @param array   $tags
     * @param Feature $feature
     */
    protected function attachTags($tags, $feature)
    {
        foreach ($tags as $tagName) {
            $tag = Tag::whereName($tagName)->first();

            if (is_null($tag)) {
                $tag = Tag::create(['name' => $tagName]);
            }

            $feature->tags()->attach($tag->id);
        }
    }

    /**
     * Get a feature suggestion by the given id.
     *
     * @param int $productId
     * @param int $id
     * @return Feature
     */
    public function getFeatureSuggestionById($productId, $id)
    {
        return Feature::with(['tags', 'status', 'vote'])->findOrFail($id);
    }

    /**
     * Set default status for feature suggestion.
     *
     * @param $feature
     */
    protected function setDefaultStatus($feature)
    {
        $status = config('status')[Status::$AWAITING_FOR_FEEDBACK];

        Status::create([
            'feature_id' => $feature->id,
            'type' => Status::$AWAITING_FOR_FEEDBACK,
            'subject' => $status['subject'],
            'message' => $status['message']
        ]);
    }

    /**
     * Update status for the given feature.
     *
     * @param Feature $feature
     * @param array   $status
     */
    protected function updateStatus($feature, $status)
    {
        $oldStatus = Status::whereFeatureId($feature->id)->first();

        if($oldStatus != $status) {
            $oldStatus->update([
                'type' => $status['type'],
                'subject' => $status['subject'],
                'message' => $status['message']
            ]);

            event(new FeatureStatusUpdated($feature, $status));
        }
    }

    /**
     * Create vote for the given feature.
     *
     * @param Feature $feature
     */
    protected function createVote($feature)
    {
        Vote::create([
            'feature_id' => $feature->id,
            'up' => 0,
            'down' => 0
        ]);
    }

    /**
     * Set default priority value for the given feature.
     *
     * @param Feature $feature
     */
    protected function setPriorityDefaultValue($feature)
    {
        Priority::create([
            'user_id' => auth()->user()->id,
            'feature_id' => $feature->id,
            'value' => 50
        ]);
    }

    /**
     * Set default development effort value for the given feature.
     *
     * @param Feature $feature
     */
    protected function setEffortDefaultValue($feature)
    {
        Effort::create([
            'user_id' => auth()->user()->id,
            'feature_id' => $feature->id,
            'value' => 80
        ]);
    }
}