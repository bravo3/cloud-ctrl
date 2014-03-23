<?php
namespace Bravo3\CloudCtrl\Entity\Google;

use Bravo3\CloudCtrl\Entity\Common\GenericZone;
use Bravo3\CloudCtrl\Enum\InstanceState;
use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Interfaces\Instance\AbstractInstance;
use Bravo3\CloudCtrl\Interfaces\Instance\NamedInstanceInterface;
use Bravo3\CloudCtrl\Interfaces\Instance\NamedInstanceTrait;
use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;
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
        $instance->setZone(new GenericZone($template->getZone()));

        switch ($template->getStatus()) {
            case 'RUNNING':
                $instance->setInstanceState(InstanceState::RUNNING);
                break;

            default:
                $instance->setInstanceState(InstanceState::UNKNOWN);

        }

        return $instance;
    }

    /**
     * Create a new Google_Service_Compute_Instance from an InstanceSchema object
     *
     * TODO: complete me
     *
     * @param InstanceSchema $schema
     * @param string         $instance_name
     * @param ZoneInterface  $zone
     * @return \Google_Service_Compute_Instance
     */
    public static function toGoogleServiceComputeInstance(
        InstanceSchema $schema,
        $instance_name,
        ZoneInterface $zone = null
    ) {
        $instance = new \Google_Service_Compute_Instance();

        $instance->setName($instance_name);
        if ($zone) {
            $instance->setZone($zone->getZoneName());
        } else {
            $zones = $schema->getZones();
            if (count($zones)) {
                $instance->setZone($zones[0]->getZoneName());
            }
        }

        $tags = $schema->getTags();
        if (count($tags)) {
            $google_tag_collection = new \Google_Service_Compute_Tags();

            foreach ($tags as $tag) {

            }

            $instance->setTags($google_tag_collection);
        }

        return $instance;
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