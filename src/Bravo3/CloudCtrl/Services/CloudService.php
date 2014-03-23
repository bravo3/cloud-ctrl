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
use Bravo3\CloudCtrl\Services\Common\ResourceManager;
use Bravo3\CloudCtrl\Services\Google\GoogleService;


/**
 * Abstract base class for all cloud service providers
 */
abstract class CloudService
{

    /**
     * Create a new CloudService for the given provider
     *
     * @param string              $provider
     * @param CredentialInterface $credentials
     * @param string              $region
     * @return CloudService
     * @throws UnknownProviderException
     */
    public static function createCloudService($provider, CredentialInterface $credentials, $region = null)
    {
        switch ($provider) {
            case Provider::AWS:
                return new AwsService($credentials, $region);
            case Provider::AZURE:
                return new AzureService($credentials, $region);
            case Provider::GOOGLE:
                return new GoogleService($credentials, $region);

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
     * @var InstanceManager
     */
    protected $instanceManager;

    /**
     * @var ResourceManager
     */
    protected $resourceManager;

    /**
     * @var LoadBalancerManager
     */
    protected $loadBalancerManager;


    protected function __construct(CredentialInterface $credentials = null, $region = null)
    {
        $this->setCredentials($credentials);

        if ($region !== null) {
            $this->region = $region;
        }

        $this->createInstanceManager();
        $this->createResourceManager();
        $this->createLoadBalancerManager();
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
        return $this->instanceManager;
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
        return $this->loadBalancerManager;
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
        return $this->resourceManager;
    }


}
 