<?php
namespace Bravo3\CloudCtrl\Interfaces\Common;

interface ProjectAwareInterface
{
    /**
     * Set the project ID
     *
     * @param string $project_id
     * @return $this
     */
    public function setProjectId($project_id);

    /**
     * Get the project ID
     *
     * @return string
     */
    public function getProjectId();


} 