<?php
namespace Bravo3\Cache;

/**
 * A service that has a need for cache
 */
interface CachingServiceInterface
{

    /**
     * Set the services cache pool
     *
     * @param PoolInterface $pool
     * @return mixed
     */
    public function setCachePool(PoolInterface $pool);


    /**
     * Get the cache pool
     *
     * @return PoolInterface
     */
    public function getCachePool();

}
 