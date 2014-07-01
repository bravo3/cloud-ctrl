<?php
namespace Bravo3\CloudCtrl\Entity\Aws;

use Bravo3\CloudCtrl\Collections\ImageCollection;
use Bravo3\CloudCtrl\Enum\Architecture;
use Bravo3\CloudCtrl\Enum\ImageState;
use Bravo3\CloudCtrl\Interfaces\Common\AbstractImage;
use Guzzle\Service\Resource\Model;

class AwsImage extends AbstractImage
{
    /**
     * Create an AwsImage from a Guzzle Model
     *
     * @param Model $r
     * @return ImageCollection
     */
    public static function fromApiResult(Model $r) {
        $collection = new ImageCollection();

        $addReservation = function (array $instances) use (&$collection) {
            foreach ($instances as $item) {
                $image = new self();

                // Basic details
                $image->setImageId($item['ImageId']);
                $image->setImageLocation($item['ImageLocation']);
                $image->setOwner($item['OwnerId']);
                $image->setPublic($item['Public']);
                $image->setArchitecture(Architecture::memberByValue($item['Architecture']));
                $image->setName($item['Name']);
                $image->setDescription($item['Description']);
                $image->setImageType($item['ImageType']);
                $image->setState(ImageState::memberByValue(strtoupper($item['State'])));

                if (isset($item['Tags'])) {
                    if ($tags = $item['Tags']) {
                        foreach ($tags as $tag) {
                            $image->addTag($tag['Key'], $tag['Value']);
                        }
                    }
                }

                $collection->addImage($image);
            }
        };

        if ($reservations = $r->get('Reservations')) {
            foreach ($reservations as $reservation) {
                $addReservation($reservation['Images']);
            }
        } else {
            $addReservation($r->get('Images') ? : []);
        }

        return $collection;
    }

}
