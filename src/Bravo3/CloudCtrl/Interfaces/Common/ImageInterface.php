<?php
namespace Bravo3\CloudCtrl\Interfaces\Common;

use Bravo3\CloudCtrl\Enum\Architecture;
use Bravo3\CloudCtrl\Enum\ImageState;

interface ImageInterface
{
    /**
     * Get Architecture
     *
     * @return Architecture
     */
    public function getArchitecture();

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get ImageId
     *
     * @return string
     */
    public function getImageId();

    /**
     * Get ImageLocation
     *
     * @return string
     */
    public function getImageLocation();
    /**
     * Get image type
     *
     * @return string
     */
    public function getImageType();

    /**
     * Get IsPublic
     *
     * @return boolean
     */
    public function isPublic();

    /**
     * Get image name
     *
     * @return string
     */
    public function getName();

    /**
     * Get Owner
     *
     * @return string
     */
    public function getOwner();

    /**
     * Get State
     *
     * @return ImageState
     */
    public function getState();

    /**
     * Get Tags
     *
     * @return array
     */
    public function getTags();

    /**
     * Get a specific tag
     *
     * @param string $key
     * @return string
     */
    public function getTag($key);

} 