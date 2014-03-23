<?php
namespace Bravo3\Cache;

use Bravo3\Cache\Ephemeral\EphemeralCachePool;

/**
 * Implements the caching service interface
 */
trait CachingServiceTrait
{

    protected $cache_pool = null;

    /**
     * Set the services cache pool
     *
     * @param PoolInterface $pool
     * @return mixed
     */
    public function setCachePool(PoolInterface $pool)
    {
        $this->cache_pool = $pool;
    }

    /**
     * Get the cache pool
     *
     * @return PoolInterface
     */
    public function getCachePool()
    {
        if ($this->cache_pool === null) {
            $this->cache_pool = new EphemeralCachePool();
        }

        return $this->cache_pool;
    }

    /**
     * Shorthand to get an item from the cache pool
     *
     * @param $key
     * @return ItemInterface
     */
    public function getCacheItem($key) {
        return $this->getCachePool()->getItem($key);
    }

}
 