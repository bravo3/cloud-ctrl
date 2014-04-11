<?php
namespace Bravo3\CloudCtrl\Entity\Aws;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Enum\InstanceState;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Interfaces\Instance\AbstractInstance;
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
     *
     *
     * @param Model $r
     * @return InstanceCollection
     */
    public static function fromApiResult(Model $r)
    {
        $out = [];

        $request_id     = $r->get('requestId');
        $reservation_id = $r->get('ReservationId');
        $owner          = $r->get('OwnerId');
        $groups         = $r->get('Groups');
        $instances      = $r->get('Instances');

        foreach ($instances as $item) {
            $instance = new self();
            $instance->setInstanceId($item['InstanceId']);
            $instance->setImageId($item['ImageId']);
            $instance->setArchitecture($item['Architecture']);

            switch ($item['State']['Name']) {
                case 'pending':
                    $instance->setInstanceState(InstanceState::PENDING);
                    break;
                case 'running':
                    $instance->setInstanceState(InstanceState::RUNNING);
                    break;
            }

            $out[] = $instance;
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