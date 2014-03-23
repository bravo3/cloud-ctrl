<?php
namespace Bravo3\CloudCtrl\Filters\Traits;

/**
 * Filter by a unique ID
 */
trait IdentityFilterTrait
{

    /**
     * @var string[]
     */
    protected $idList = [];

    /**
     * Set identity list
     *
     * @param \string[] $idList
     * @return $this
     */
    public function setIdList($idList)
    {
        $this->idList = $idList;
        return $this;
    }

    /**
     * Get identity list
     *
     * @return \string[]
     */
    public function getIdList()
    {
        return $this->idList;
    }

    /**
     * Add an identity to the list
     *
     * @param $id
     * @return $this
     */
    public function addId($id)
    {
        $this->idList[] = $id;
        return $this;
    }

} 