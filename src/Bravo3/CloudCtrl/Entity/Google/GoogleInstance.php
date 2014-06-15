<?php
namespace Bravo3\CloudCtrl\Entity\Google;

use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Common\IpAddress;
use Bravo3\CloudCtrl\Entity\Common\Zone;
use Bravo3\CloudCtrl\Enum\InstanceState;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Interfaces\Instance\AbstractInstance;
use Bravo3\CloudCtrl\Interfaces\Instance\NamedInstanceInterface;
use Bravo3\CloudCtrl\Interfaces\Instance\NamedInstanceTrait;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;
use Bravo3\CloudCtrl\Mappers\Google\GoogleInstanceStateMapper;
use Bravo3\CloudCtrl\Mappers\Google\GoogleNameMapper;
use Bravo3\CloudCtrl\Schema\InstanceSchema;

class GoogleInstance extends AbstractInstance implements NamedInstanceInterface
{
    use NamedInstanceTrait;

    /**
     * @var string
     */
    protected $link;

    /**
     * The name of the cloud provider
     *
     * @see \Bravo3\CloudCtrl\Enum\Provider
     * @return string
     */
    public function getProvider()
    {
        return Provider::GOOGLE;
    }

    /**
     * Create a new GoogleInstance from a Google_Service_Compute_Operation object
     *
     * TODO: complete me
     *
     * @param \Google_Service_Compute_Operation $template
     * @return GoogleInstance
     */
    public static function fromGoogleServiceComputeOperation(\Google_Service_Compute_Operation $template)
    {
        $instance = new self();
        $instance->setInstanceName($template->getName());
        $instance->setInstanceId($template->getId());
        $instance->setLink($template->getSelfLink());
        $instance->setZone(new Zone($template->getZone()));
        $instance->setInstanceState(GoogleInstanceStateMapper::fromGoogleCode($template->getStatus()));

        return $instance;
    }

    /**
     * Create a new GoogleInstance from a Google_Service_Compute_Instance object
     *
     * TODO: complete me
     *
     * @param \Google_Service_Compute_Instance $template
     * @return GoogleInstance
     */
    public static function fromGoogleServiceComputeInstance(\Google_Service_Compute_Instance $template)
    {
        $instance = new self();
        $instance->setInstanceName($template->getName());
        $instance->setInstanceId($template->getId());
        $instance->setLink($template->getSelfLink());
        $instance->setZone(new Zone($template->getZone()));
        $instance->setInstanceState(GoogleInstanceStateMapper::fromGoogleCode($template->getStatus()));

        return $instance;
    }

    /**
     * Create a new InstanceCollection from a Google API result array
     *
     * @param array $instances
     * @return InstanceCollection
     */
    public static function fromGoogleApiArray(array $instances)
    {
        $collection = new InstanceCollection();

        foreach ($instances as $item) {
            $instance = new self();

            // Basic details
            $instance->setInstanceId($item['name']);
            //$instance->setImageId($item['ImageId']);
            //$instance->setArchitecture(Architecture::memberByValue($item['Architecture']));
            $instance->setInstanceState(GoogleInstanceStateMapper::fromGoogleCode($item['status']));
            $instance->setInstanceSize(GoogleNameMapper::toShortForm($item['machineType']));
            $instance->setZone(new Zone(GoogleNameMapper::toShortForm($item['zone'])));

            if (isset($item['tags'])) {
                if ($tags = $item['tags']['items']) {
                    foreach ($tags as $tag) {
                        $instance->addTag($tag, $tag);
                    }
                }
            }

            foreach ($item['networkInterfaces'] as $network) {
                $private = $network['networkIP'];
                $instance->setPrivateAddress(new IpAddress($private));

                if (isset($network['accessConfigs'])) {
                    if (isset($network['accessConfigs'][0]['natIP'])) {
                        $public = $network['accessConfigs'][0]['natIP'];
                        $instance->setPublicAddress(new IpAddress($public));
                    }
                }

                // Instance design model doesn't allow for more IPs - this needs to be reconsidered
                // See issue #3
                break;
            }

            $collection->addInstance($instance);
        }

        return $collection;
    }

    /**
     * Set Link
     *
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Get Link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }


}