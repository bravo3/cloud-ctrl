<?php
namespace Bravo3\CloudCtrl\Mappers\Google;

/**
 * Convert Google resource names to/from long-form/short-form
 */
class GoogleNameMapper
{

    /**
     * Convert URL-formed resource names to their simple form
     *
     * eg
     * "https://www.googleapis.com/compute/v1/projects/php-cloud-controller/zones/us-central1-a/machineTypes/f1-micro"
     * becomes
     * "f1-micro"
     *
     * @param $resource
     * @return string
     */
    public static function toShortForm($resource)
    {
        $parts = explode('/', $resource);
        return array_pop($parts);
    }


}
 