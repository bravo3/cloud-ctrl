<?php
namespace Bravo3\CloudCtrl\Entity\Aws;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Common\IpAddress;
use Bravo3\CloudCtrl\Entity\Common\Zone;
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
        $collection = new InstanceCollection();

        $addReservation = function (array $instances) use (&$collection) {
            foreach ($instances as $item) {
                $instance = new self();

                // Basic details
                $instance->setInstanceId($item['InstanceId']);
                $instance->setImageId($item['ImageId']);
                $instance->setArchitecture(Architecture::memberByValue($item['Architecture']));
                $instance->setInstanceState(AwsInstanceStateMapper::fromAwsCode($item['State']['Code']));
                $instance->setInstanceSize($item['InstanceType']);
                $instance->setZone(new Zone($item['Placement']['AvailabilityZone']));

                // This works at current, but AWS doesn't return the region name
                $instance->setRegion(substr($instance->getZone()->getZoneName(), 0, -1));

                // No tags on TERMINATED instances
                if (isset($item['Tags'])) {
                    if ($tags = $item['Tags']) {
                        foreach ($tags as $tag) {
                            $instance->addTag($tag['Key'], $tag['Value']);
                        }
                    }
                }

                // IP address details where available
                if (isset($item['PublicIpAddress'])) {
                    $instance->setPublicAddress(new IpAddress($item['PublicIpAddress'], null, $item['PublicDnsName']));
                }
                if (isset($item['PrivateIpAddress'])) {
                    $instance->setPrivateAddress(
                        new IpAddress($item['PrivateIpAddress'], null, $item['PrivateDnsName'])
                    );
                }

                $collection->addInstance($instance);
            }
        };

        if ($reservations = $r->get('Reservations')) {
            foreach ($reservations as $reservation) {
                $addReservation($reservation['Instances']);
            }
        } else {
            $addReservation($r->get('Instances') ? : []);
        }

        return $collection;
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