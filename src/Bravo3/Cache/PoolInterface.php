<?php
namespace Bravo3\Cache;

/**
 * Taken from the PSR-6 proposal.
 *
 * @see https://github.com/Crell/fig-standards/blob/Cache/proposed/cache.md
 *
 * It is intended this be replace by PSR caching standards when such things are approved.
 *
 * --------------------------------------------------------------------------------------------------------------------
 *
 * Caching pool that generates \Bravo3\Cache\ItemInterface objects.
 */
interface PoolInterface
{
    /**
     * Returns a Cache Item representing the specified key.
     *
     * This method must always return an ItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param string $key
     *   The key for which to return the corresponding Cache Item.
     * @return \Bravo3\Cache\ItemInterface
     *   The corresponding Cache Item.
     * @throws \Bravo3\Cache\InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     */
    public function getItem($key);

    /**
     * Returns a traversable set of cache items.
     *
     * @param array $keys
     *   An indexed array of keys of items to retrieve.
     * @return \Traversable
     *   A traversable collection of Cache Items in the same order as the $keys
     *   parameter, keyed by the cache keys of each item. If no items are found
     *   an empty Traversable collection will be returned.
     */
    public function getItems(array $keys);

    /**
     * Deletes all items in the pool.
     *
     * @return PoolInterface
     *   The current pool.
     */
    public function clear();
}
