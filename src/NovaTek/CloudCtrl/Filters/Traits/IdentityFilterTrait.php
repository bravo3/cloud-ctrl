<?php
namespace NovaTek\CloudCtrl\Filters\Traits;

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
     * @return IdentityFilterTrait
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
     * @return IdentityFilterTrait
     */
    public function addId($id)
    {
        $this->idList[] = $id;
        return $this;
    }

} 