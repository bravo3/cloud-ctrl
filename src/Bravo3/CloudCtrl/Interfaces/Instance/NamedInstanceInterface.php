<?php
namespace Bravo3\CloudCtrl\Interfaces\Instance;

/**
 * An instance with a mandatory name
 */
interface NamedInstanceInterface
{
    /**
     * Set the instance name
     *
     * @param string $name
     * @return $this
     */
    public function setInstanceName($name);

    /**
     * Get the instance name
     *
     * @return string
     */
    public function getInstanceName();

}
 