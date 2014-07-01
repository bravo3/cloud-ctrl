<?php
namespace Bravo3\CloudCtrl\Filters\Traits;

/**
 * Filter by a list of owners
 */
trait OwnerFilterTrait
{

    /**
     * @var string[]
     */
    protected $owners = [];

    /**
     * Set owners
     *
     * @param string[] $owners
     * @return $this
     */
    public function setOwners($owners)
    {
        $this->owners = $owners;
        return $this;
    }

    /**
     * Get owners
     *
     * @return string[]
     */
    public function getOwners()
    {
        return $this->owners;
    }

    /**
     * Add an owner
     *
     * @param string $owner
     * @return $this
     */
    public function addOwner($owner)
    {
        $this->owners[] = $owner;
        return $this;
    }

} 