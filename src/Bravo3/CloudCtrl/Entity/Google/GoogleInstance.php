<?php
namespace Bravo3\CloudCtrl\Entity\Google;

use Bravo3\CloudCtrl\Entity\Common\Zone;
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

        switch ($template->getStatus()) {
            case 'RUNNING':
                $instance->setInstanceState(InstanceState::RUNNING);
                break;
            case 'PENDING':
                $instance->setInstanceState(InstanceState::PENDING);
                break;

            default:
                $instance->setInstanceState(InstanceState::UNKNOWN);
        }

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

        switch ($template->getStatus()) {
            case 'RUNNING':
                $instance->setInstanceState(InstanceState::RUNNING);
                break;
            case 'PENDING':
                $instance->setInstanceState(InstanceState::PENDING);
                break;

            default:
                $instance->setInstanceState(InstanceState::UNKNOWN);
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