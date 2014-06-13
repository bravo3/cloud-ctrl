<?php
namespace Bravo3\CloudCtrl\Entity\Aws;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Enum\Architecture;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Interfaces\Instance\AbstractInstance;
use Bravo3\CloudCtrl\Mappers\Aws\AwsInstanceStateMapper;
use Guzzle\Service\Resource\Model;

class AwsInstance extends AbstractInstance
{
    /**
     * @var string
     */
    protected $region;


    /**
     * The name of the cloud provider
     *
     * @see \Bravo3\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider()
    {
        return Provider::AWS;
    }


    /**
     * Create an AwsInstance from a Guzzle Model
     *
     * @param Model $r
     * @return InstanceCollection
     */
    public static function fromApiResult(Model $r)
    {
        $out = [];

        $addReservation = function(array $instances) use (&$out) {
            foreach ($instances as $item) {
                // debug
                echo "fromApiResult():\n";
                var_dump($item);


                $instance = new self();
                $instance->setInstanceId($item['InstanceId']);
                $instance->setImageId($item['ImageId']);
                $instance->setArchitecture(Architecture::memberByValue($item['Architecture']));
                $instance->setInstanceState(AwsInstanceStateMapper::fromAwsCode($item['State']['Code']));
                $instance->setInstanceSize($item['InstanceType']);

                if ($tags = $item['Tags']) {
                    foreach ($tags as $tag) {
                        $instance->addTag($tag['Key'], $tag['Value']);
                    }
                }

                $out[] = $instance;

            }
        };

        if ($reservations = $r->get('Reservations')) {
            foreach ($reservations as $reservation) {
                $addReservation($reservation['Instances']);
            }
        } else {
            $addReservation($r->get('Instances'));
        }

        return new InstanceCollection($out);
    }


    /**
     * Set the AWS region name
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get the AWS region name
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }


} 