<?php
namespace NovaTek\CloudCtrl\Interfaces\Common;

trait ProjectAwareTrait
{
    protected $project_id;

    /**
     * Set ProjectId
     *
     * @param mixed $project_id
     * @return $this
     */
    public function setProjectId($project_id)
    {
        $this->project_id = $project_id;
        return $this;
    }

    /**
     * Get ProjectId
     *
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->project_id;
    }


} 