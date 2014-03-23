<?php
namespace Bravo3\CloudCtrl\Filters\Traits;

/**
 * Filter by a key/value list of tags
 */
trait TagFilterTrait
{

    /**
     * @var array
     */
    protected $tags;

    /**
     * Set tags
     *
     * @param array $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add or set a tag
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function addTag($key, $value)
    {
        $this->tags[$key] = $value;
        return $this;
    }

} 