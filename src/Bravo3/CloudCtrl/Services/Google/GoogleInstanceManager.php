<?php
namespace Bravo3\CloudCtrl\Services\Google;

use Bravo3\Cache\CachingServiceInterface;
use Bravo3\Cache\CachingServiceTrait;
use Bravo3\CloudCtrl\Collections\InstanceCollection;
use Bravo3\CloudCtrl\Entity\Google\GoogleInstance;
use Bravo3\CloudCtrl\Entity\Google\GoogleInstanceFactory;
use Bravo3\CloudCtrl\Enum\Google\Scope;
use Bravo3\CloudCtrl\Exceptions\InvalidCredentialsException;
use Bravo3\CloudCtrl\Exceptions\UnexpectedResultException;
use Bravo3\CloudCtrl\Filters\InstanceFilter;
use Bravo3\CloudCtrl\Reports\InstanceListReport;
use Bravo3\CloudCtrl\Reports\InstanceProvisionReport;
use Bravo3\CloudCtrl\Reports\SuccessReport;
use Bravo3\CloudCtrl\Schema\InstanceSchema;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;
use Bravo3\CloudCtrl\Services\Common\UniqueInstanceNameGenerator;
use Bravo3\CloudCtrl\Services\Google\Io\GoogleIo;
use Bravo3\NetworkProxy\Implementation\HttpProxy;
use Bravo3\NetworkProxy\Implementation\SocksProxy;

/**
 * Google Instance Manager
 *
 * Responsible for handling all Google Cloud Compute instances and instance resources
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

        $client  = $this->getClient([Scope::COMPUTE_WRITE], $credentials);
        $service = new \Google_Service_Compute($client);

        $zones      = $schema->getZones();
        $zone_count = count($zones);

        $name_generator = $schema->getNameGenerator();
        if (is_null($name_generator)) {
            $name_generator = new UniqueInstanceNameGenerator();
        }

        $report  = new InstanceProvisionReport();
        $factory = new GoogleInstanceFactory($schema, $credentials->getProjectId());

        // We need to spawn each instance 1 at a time, iterate through the count, picking the next sequential zone
        for ($i = 0; $i < $count; $i++) {
            $zone = $zones[$i % $zone_count];
            $name = $name_generator->getInstanceName($schema, $zone, $i);

            $item = $service->instances->insert(
                $credentials->getProjectId(),
                $zone->getZoneName(),
                $factory->createGoogleInstance($name, $zone)
            );

            if (!($item instanceof \Google_Service_Compute_Operation)) {
                throw new UnexpectedResultException("Server returned an unexpected instance object", 0, $item);
            }

            $instance = GoogleInstance::fromGoogleServiceComputeOperation($item);
            $this->logCreateInstance($i, $instance, $name);
            $report->addInstance($instance);
        }

        $this->cacheAuthToken($client);

        return $report;
    }

    /**
     * Start a set of stopped instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    public function startInstances(InstanceFilter $instances)
    {
        // TODO: Implement startInstances() method.
    }

    /**
     * Stop a set of running instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    public function stopInstances(InstanceFilter $instances)
    {
        // TODO: Implement stopInstances() method.
    }

    /**
     * Terminate a set of instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    public function terminateInstances(InstanceFilter $instances)
    {
        // TODO: Implement terminateInstances() method.
    }

    /**
     * Restart a set of instances
     *
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    public function restartInstances(InstanceFilter $instances)
    {
        // TODO: Implement restartInstances() method.
    }


    /**
     * Get a list of instances
     *
     * @param InstanceFilter $instances
     * @throws UnexpectedResultException
     * @return InstanceListReport
     */
    public function describeInstances(InstanceFilter $instances)
    {
        $credentials = $this->validateGoogleCredentials($this->getCloudService()->getCredentials());

        $client = $this->getClient([Scope::COMPUTE_READ], $credentials);

        $service = new \Google_Service_Compute($client);
        $report  = new InstanceListReport();

        // Query options
        $opts = [];

        $filter = $this->createOptionsFromFilter($instances);
        if ($filter) {
            $opts['filter'] = $filter;
        }

        // Make the API call to Google -
        $out = $service->instances->aggregatedList($credentials->getProjectId(), $opts);

        // What we're looking for must be a list of instances -
        if (!($out instanceof \Google_Service_Compute_InstanceAggregatedList)) {
            throw new UnexpectedResultException("Server returned an unexpected result", 0, $out);
        }

        $items      = $out->getItems();
        $collection = new InstanceCollection();

        foreach ($items as $zone_items) {
            if (!isset($zone_items['instances'])) {
                continue;
            }

            $collection->addCollection(GoogleInstance::fromGoogleApiArray($zone_items['instances']));
        }

        $report->setSuccess(true);
        $report->setInstances($collection);

        $this->cacheAuthToken($client);

        return $report;
    }

    /**
     * Set tags for a set of instances
     *
     * @param array          $tags
     * @param InstanceFilter $instances
     * @return SuccessReport
     */
    public function setInstanceTags(array $tags, InstanceFilter $instances)
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

        if ($zones = $filter->getZoneList()) {
            foreach ($zones as $zone) {
                //$out .= 'zone eq "'.$zone->getZoneName().'" ';
            }
        }

        return trim($out);
    }


}
 