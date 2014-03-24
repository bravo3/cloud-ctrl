<?php
namespace Bravo3\CloudCtrl\Services\Google;

use Bravo3\Cache\CachingServiceInterface;
use Bravo3\Cache\CachingServiceTrait;
use Bravo3\CloudCtrl\Entity\Google\GoogleInstance;
use Bravo3\CloudCtrl\Enum\Google\Scope;
use Bravo3\CloudCtrl\Exceptions\InvalidCredentialsException;
use Bravo3\CloudCtrl\Exceptions\UnexpectedResultException;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Interfaces\Instance\InstanceNameGeneratorInterface;
use Bravo3\CloudCtrl\Reports\InstanceListReport;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;
use Bravo3\CloudCtrl\Services\Common\UniqueInstanceNameGenerator;

/**
 *
 */
class GoogleInstanceManager extends InstanceManager implements CachingServiceInterface
{
    use GoogleApiTrait;


    /**
     * Create new instances
     *
     * @param int            $count
     * @param InstanceSchema $schema
     * @return InstanceProvisionReport
     * @throws InvalidCredentialsException
     */
    public function createInstances($count, InstanceSchema $schema)
    {
        $credentials = $this->validateGoogleCredentials($this->getCloudService()->getCredentials());

        $client = $this->getClient([Scope::COMPUTE_WRITE], $credentials);
        $service = new \Google_Service_Compute($client);

        $zones = $schema->getZones();
        $zoneCount = count($zones);

        // We need to spawn each instance 1 at a time, iterate through the count, picking the next sequential zone
        $name_generator = $schema->getNameGenerator();
        if (is_null($name_generator)) {
            $name_generator = new UniqueInstanceNameGenerator();
        }

        $report = new InstanceProvisionReport();

        for ($i = 0; $i < $count; $i++) {
            $zone = $zones[$i % $zoneCount];
            $name = $name_generator->getInstanceName($schema, $zone, $i);

            $spec = GoogleInstance::toGoogleServiceComputeInstance($schema, $name, $zone->getZoneName());
            $item = $service->instances->insert($credentials->getProjectId(), $zone->getZoneName(), $spec);

            // TODO: check the object type!
            if (!($item instanceof \Google_Service_Compute_Instance)) {
                throw new UnexpectedResultException("Server returned an unexpected instance object", 0, $item);
            }

            $report->addInstance(GoogleInstance::fromGoogleServiceComputeInstance($item));
        }

        $this->cacheAuthToken($client);

        return $report;
    }

    public function startInstances(InstanceFilter $instances)
    {
        // TODO: Implement startInstances() method.
    }

    public function stopInstances(InstanceFilter $instances)
    {
        // TODO: Implement stopInstances() method.
    }

    public function terminateInstances(InstanceFilter $instances)
    {
        // TODO: Implement terminateInstances() method.
    }

    public function restartInstances(InstanceFilter $instances)
    {
        // TODO: Implement restartInstances() method.
    }


    /**
     * Get a list of instances
     *
     * @param InstanceFilter $instances
     * @throws \Bravo3\CloudCtrl\Exceptions\UnexpectedResultException
     * @return InstanceListReport
     */
    public function describeInstances(InstanceFilter $instances)
    {
        $credentials = $this->validateGoogleCredentials($this->getCloudService()->getCredentials());

        $client = $this->getClient([Scope::COMPUTE_READ], $credentials);
        $service = new \Google_Service_Compute($client);

        $report = new InstanceListReport();

        // Query options
        $opts = [];

        $filter = $this->createOptionsFromFilter($instances);
        if ($filter) {
            $opts['filter'] = $filter;
        }

        // Google can only search a single zone at a time
        foreach ($instances->getZoneList() as $zone) {
            // Make the API call to Google -
            $out = $service->instances->listInstances($credentials->getProjectId(), $zone->getZoneName(), $opts);

            // What we're looking for must be a list of instances -
            if (!($out instanceof \Google_Service_Compute_InstanceList)) {
                throw new UnexpectedResultException("Server returned an unexpected result", 0, $out);
            }

            $items = $out->getItems();
            foreach ($items as $item) {
                // Should be an instance -
                if (!($item instanceof \Google_Service_Compute_Instance)) {
                    throw new UnexpectedResultException("Server returned an unexpected instance object", 0, $item);
                }

                $report->addInstance(GoogleInstance::fromGoogleServiceComputeInstance($item));
            }
        }

        $report->setSuccess(true);

        $this->cacheAuthToken($client);

        return $report;
    }

    public function setInstanceTags($tags, InstanceFilter $instances)
    {
        // TODO: Implement setInstanceTags() method.
    }


    /**
     * Create a compute filter from an InstaceFilter
     *
     * @param InstanceFilter $filter
     * @return string
     */
    protected function createOptionsFromFilter(InstanceFilter $filter)
    {
        $out = '';

        return $out;
    }


}
 