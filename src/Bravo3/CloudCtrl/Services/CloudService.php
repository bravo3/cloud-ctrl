<?php
namespace Bravo3\CloudCtrl\Services;


use Bravo3\CloudCtrl\Enum\Provider;
use Bravo3\CloudCtrl\Exceptions\UnknownProviderException;
use Bravo3\CloudCtrl\Interfaces\Common\RegionAwareInterface;
use Bravo3\CloudCtrl\Interfaces\Credentials\CredentialInterface;
use Bravo3\CloudCtrl\Services\Aws\AwsService;
use Bravo3\CloudCtrl\Services\Aws\AzureService;
use Bravo3\CloudCtrl\Services\Common\InstanceManager;
use Bravo3\CloudCtrl\Services\Common\LoadBalancerManager;
use Bravo3\CloudCtrl\Services\Common\ObjectStore;
use Bravo3\CloudCtrl\Services\Common\ResourceManager;
use Bravo3\CloudCtrl\Services\Google\GoogleService;
use Bravo3\NetworkProxy\NetworkProxyInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;


/**
 * Abstract base class for all cloud service providers
 */
abstract class CloudService implements LoggerAwareInterface
{
    use LoggerAwareTrait;


    /**
     * Create a new CloudService for the given provider
     *
     * @param string                $provider
     * @param CredentialInterface   $credentials
     * @param string                $region
     * @param NetworkProxyInterface $proxy
     * @throws UnknownProviderException
     * @return CloudService
     */
    public static function createCloudService(
        $provider,
        CredentialInterface $credentials,
        $region = null,
        NetworkProxyInterface $proxy = null
    ) {
        switch ($provider) {
            case Provider::AWS:
                return new AwsService($credentials, $region, $proxy);
            case Provider::AZURE:
                return new AzureService($credentials, $region, $proxy);
            case Provider::GOOGLE:
                return new GoogleService($credentials, $region, $proxy);

            default:
                throw new UnknownProviderException();
        }
    }

    /**
     * @var CredentialInterface
     */
    protected $credentials;

    /**
     * @var string
     */
    protected $region = null;

    /**
     * @var NetworkProxyInterface
     */
    protected $proxy;

    /**
     * @var InstanceManager
     */
    protected $instance_manager;

    /**
     * @var ResourceManager
     */
    protected $resource_manager;

    /**
     * @var LoadBalancerManager
     */
    protected $load_balancer_manager;

    /**
     * @var ObjectStore
     */
    protected $object_store;


    protected function __construct(
        CredentialInterface $credentials = null,
        $region = null,
        NetworkProxyInterface $proxy = null
    ) {
        $this->setCredentials($credentials);
        $this->setProxy($proxy);

        if ($region !== null) {
            $this->region = $region;
        }

        // TODO: convert to lazy loading!
        $this->createInstanceManager();
        $this->createResourceManager();
        $this->createLoadBalancerManager();
        $this->createObjectStore();
    }


    // --

    /**
     * Set Credentials
     *
     * @param CredentialInterface $credentials
     * @return CloudService
     */
    public function setCredentials(CredentialInterface $credentials)
    {
        $this->credentials = $credentials;

        if ($this->credentials instanceof RegionAwareInterface) {
            $this->setRegion($this->credentials->getRegion());
        }

        return $this;
    }

    /**
     * Get Credentials
     *
     * @return CredentialInterface
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Set Region
     *
     * @param string $region
     * @return CloudService
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Get Region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Create the instance manager
     */
    abstract protected function createInstanceManager();

    /**
     * Get InstanceManager
     *
     * @return InstanceManager
     */
    public function getInstanceManager()
    {
        return $this->instance_manager;
    }

    /**
     * Create a load balancer manager
     */
    abstract protected function createLoadBalancerManager();

    /**
     * Get LoadBalancerManager
     *
     * @return LoadBalancerManager
     */
    public function getLoadBalancerManager()
    {
        return $this->load_balancer_manager;
    }

    /**
     * Create a resource manager to control instance resources
     */
    abstract protected function createResourceManager();

    /**
     * Get ResourceManager
     *
     * @return ResourceManager
     */
    public function getResourceManager()
    {
        return $this->resource_manager;
    }

    /**
     * Create an object store
     */
    abstract protected function createObjectStore();

    /**
     * Get ObjectStore
     *
     * @return ObjectStore
     */
    public function getObjectStore()
    {
        return $this->object_store;
    }


    /**
     * Set network proxy
     *
     * A SOCKS or HTTP proxy
     *
     * @param NetworkProxyInterface $proxy
     * @return $this
     */
    public function setProxy($proxy = null)
    {
        $this->proxy = $proxy;
        return $this;
    }

    /**
     * Get network proxy
     *
     * A SOCKS or HTTP proxy
     *
     * @return NetworkProxyInterface
     */
    public function getProxy()
    {
        return $this->proxy;
    }


}
 