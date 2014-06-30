<?php
namespace Bravo3\CloudCtrl\Collections;


use Bravo3\CloudCtrl\Interfaces\Common\ImageInterface;

class ImageCollection implements \IteratorAggregate
{
    /**
     * @var ImageInterface[]
     */
    protected $items;

    /**
     * @param ImageInterface[] $items
     */
    function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Add an instance to the collection
     *
     * @param ImageInterface $instance
     */
    public function addInstance(ImageInterface $instance)
    {
        $this->items[] = $instance;
    }

    /**
     * Add a collection to this one
     *
     * @param ImageCollection $collection
     */
    public function addCollection(ImageCollection $collection)
    {
        foreach ($collection as $item) {
            $this->items[] = $item;
        }
    }

    /**
     * Get an instance by its ID
     *
     * @param $id
     * @return ImageInterface|null
     */
    public function getImageById($id)
    {
        foreach ($this->items as $instance) {
            if ($instance->getImageId() == $id) {
                return $instance;
            }
        }
        return null;
    }

    public function count()
    {
        return count($this->items);
    }

    public function toArray()
    {
        return $this->items;
    }
}