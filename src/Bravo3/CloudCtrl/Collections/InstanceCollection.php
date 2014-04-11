<?php
namespace Bravo3\CloudCtrl\Collections;

use Bravo3\CloudCtrl\Interfaces\Instance\InstanceInterface;

class InstanceCollection implements \IteratorAggregate
{
    /**
     * @var InstanceInterface[]
     */
    protected $items;

    /**
     * @param InstanceInterface[] $items
     */
    function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Get an instance by its ID
     *
     * @param $id
     * @return InstanceInterface|null
     */
    public function getInstanceById($id) {
        foreach ($this->items as $instance) {
            if ($instance->getInstanceId() == $id) {
                return $instance;
            }
        }
        return null;
    }

    public function count() {
        return count($this->items);
    }
}