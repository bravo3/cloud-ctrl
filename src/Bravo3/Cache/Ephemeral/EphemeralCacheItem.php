<?php
namespace Bravo3\Cache\Ephemeral;

use Bravo3\Cache\ItemInterface;

/**
 * Non-persistent ephemeral cache storage
 */
class EphemeralCacheItem implements ItemInterface
{
    protected $key;
    protected $value = null;
    protected $ttl = null;
    protected $hit = false;

    function __construct($key)
    {
        $this->key = $key;
    }


    /**
     * Of questionable relevance
     *
     * @throws \Exception
     * @return bool
     */
    public function hasExpired()
    {
        if ($this->ttl === null) {
            return false;
        } elseif ($this->ttl instanceof \DateTime) {
            return new \DateTime() < $this->ttl;
        } else {
            throw new \Exception("Unknown TTL value");
        }
    }

    /**
     * Returns the key for the current cache item.
     *
     * The key is loaded by the Implementing Library, but should be available to
     * the higher level callers when needed.
     *
     * @return string
     *   The key string for this cache item.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Retrieves the value of the item from the cache associated with this objects key.
     *
     * The value returned must be identical to the value original stored by set().
     *
     * if isHit() returns false, this method MUST return null. Note that null
     * is a legitimate cached value, so the isHit() method SHOULD be used to
     * differentiate between "null value was found" and "no value was found."
     *
     * @return mixed
     *   The value corresponding to this cache item's key, or null if not found.
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Stores a value into the cache.
     *
     * The $value argument may be any item that can be serialized by PHP,
     * although the method of serialization is left up to the Implementing
     * Library.
     *
     * Implementing Libraries MAY provide a default TTL if one is not specified.
     * If no TTL is specified and no default TTL has been set, the TTL MUST
     * be set to the maximum possible duration of the underlying storage
     * mechanism, or permanent if possible.
     *
     * @param mixed         $value
     *     The serializable value to be stored.
     * @param int|\DateTime $ttl
     *     - If an integer is passed, it is interpreted as the number of seconds
     *     after which the item MUST be considered expired.
     *     - If a DateTime object is passed, it is interpreted as the point in
     *     time after which the the item MUST be considered expired.
     *     - If no value is passed, a default value MAY be used. If none is set,
     *     the value should be stored permanently or for as long as the
     *     implementation allows.
     * @return bool
     *     Returns true if the item was successfully saved, or false if there was
     *     an error.
     */
    public function set($value = null, $ttl = null)
    {
        $this->value = $value;
        if ($ttl instanceof \DateTime) {
            $this->ttl = $ttl;
        } elseif (is_int($ttl)) {
            $this->ttl = new \DateTime(date('c', time() + $ttl));
        } elseif (is_null($ttl)) {
            $this->ttl = null;
        } else {
            throw new \InvalidArgumentException("TTL must be a DateTime object or an integer");
        }

        $this->hit = true;
        return true;
    }

    /**
     * Confirms if the cache item lookup resulted in a cache hit.
     *
     * Note: This method MUST NOT have a race condition between calling isHit()
     * and calling get().
     *
     * @return bool
     *   True if the request resulted in a cache hit.  False otherwise.
     */
    public function isHit()
    {
        return $this->hit;
    }

    /**
     * Removes the current key from the cache.
     *
     * @return ItemInterface
     *   The current item.
     */
    public function delete()
    {
        $this->value = null;
        $this->ttl   = new \DateTime();
    }

    /**
     * Confirms if the cache item exists in the cache.
     *
     * Note: This method MAY avoid retrieving the cached value for performance
     * reasons, which could result in a race condition between exists() and get().
     *
     * @return bool
     *  True if item exists in the cache, false otherwise.
     */
    public function exists()
    {
        return false;
    }

}
 