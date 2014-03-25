<?php
namespace Bravo3\CloudCtrl\Entity\Aws;

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
     * @return AwsInstance[]
     */
    public static function fromApiResult(Model $r)
    {
        $out = [];

        // TODO: Need to do a live integration test and check the result of $r
        $request_id = $r->get('requestId');
        $reservation_id = $r->get('ReservationId');
        $owner = $r->get('OwnerId');

        $groups = $r->get('Groups');
        /*
array(1) {
  [0] =>
  array(2) {
    'GroupName' =>
    string(7) "default"
    'GroupId' =>
    string(11) "sg-6d4b1406"
  }
}
         */
        $instances = $r->get('Instances');

        echo "Request: ".$request_id."\nReservation: ".$reservation_id."\nOwner: ".$owner."\n";
        var_dump($groups);
        var_dump($instances);

        foreach ($instances as $item) {
            $instance = new self();
            $instance->setInstanceId($item['InstanceId']);
        }

        die();

        return $out;
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