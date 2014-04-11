<?php
namespace Bravo3\CloudCtrl\Entity\Google;

use Bravo3\CloudCtrl\Interfaces\Zone\ZoneInterface;
use Bravo3\CloudCtrl\Schema\InstanceSchema;

class GoogleInstanceFactory
{
    const DEFAULT_NETWORK = 'default';

    /**
     * @var InstanceSchema
     */
    protected $schema;

    /**
     * @var string
     */
    protected $project_name;


    /**
     * @param InstanceSchema $schema
     * @param string         $project_name
     */
    function __construct(InstanceSchema $schema, $project_name)
    {
        $this->schema       = $schema;
        $this->project_name = $project_name;
    }


    /**
     * Create a new Google_Service_Compute_Instance from an InstanceSchema object
     *
     * @param string        $instance_name
     * @param ZoneInterface $zone
     * @return \Google_Service_Compute_Instance
     */
    public function createGoogleInstance($instance_name, ZoneInterface $zone)
    {
        $instance = new \Google_Service_Compute_Instance();

        $instance->setName($instance_name);
        $instance->setZone($zone->getZoneName());
        $instance->setMachineType($this->getMachineType($zone));
        $instance->setDisks($this->getDisks());
        $instance->setNetworkInterfaces($this->getNetworkInterfaces());

        if ($this->schema->getTags()) {
            $instance->setTags($this->getGoogleTagCollection());
        }

        return $instance;
    }

    /**
     * Get the machine type URL
     *
     * @param string        $project_name
     * @param ZoneInterface $zone
     * @return string
     */
    protected function getMachineType(ZoneInterface $zone)
    {
        return 'https://www.googleapis.com/compute/v1/projects/'.$this->project_name.'/zones/'.$zone->getZoneName().
               '/machineTypes/'.$this->schema->getInstanceSize();
    }

    /**
     * Get a Google_Service_Compute_Tags object from the schema tags
     *
     * @return \Google_Service_Compute_Tags
     */
    protected function getGoogleTagCollection()
    {
        $tags                  = $this->schema->getTags();
        $google_tag_collection = new \Google_Service_Compute_Tags();
        $google_tag_collection->setItems($tags);
        return $google_tag_collection;
    }

    /**
     * Get disks
     *
     * @return array
     */
    protected function getDisks()
    {
        $root_disk = [
            "type" => "PERSISTENT",
            "boot" => true
        ];

        // TODO: allow for an existing boot image
        if (true) {
            // New disk
            $root_disk["initializeParams"] = [
                "sourceImage" => $this->schema->getTemplateImageId()
            ];
        } else {
            // Existing disk
            $root_disk["source"] = "....";
        }

        return [$root_disk];
    }

    /**
     * Get network interfaces
     *
     * @param string $project_name
     * @return array
     */
    protected function getNetworkInterfaces()
    {
        $network = $this->schema->getNetwork();

        if (!$network) {
            // Assume project default
            $network = self::DEFAULT_NETWORK;
        }

        if (substr($network, 0, 8) != 'https://' && substr($network, 0, 7) != 'http://') {
            // Just had the name, not the URL, assume a project global network -
            $network =
                'https://www.googleapis.com/compute/v1/projects/'.$this->project_name.'/global/networks/'.$network;
        }

        return [['network' => $network]];
    }

} 