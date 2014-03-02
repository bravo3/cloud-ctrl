<?php
namespace NovaTek\CloudCtrl\Services;

use NovaTek\CloudCtrl\Credentials\Credential;
use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;
use NovaTek\CloudCtrl\Enum\Provider;
use NovaTek\CloudCtrl\Exceptions\UnknownProviderException;
use NovaTek\CloudCtrl\Providers\AwsService;
use NovaTek\CloudCtrl\Providers\AzureService;
use NovaTek\CloudCtrl\Providers\GoogleService;
use NovaTek\CloudCtrl\Services\Common\InstanceManager;
use NovaTek\CloudCtrl\Services\Common\LoadBalancerManager;
use NovaTek\CloudCtrl\Services\Common\ResourceManager;


/**
 * Abstract base class for all cloud service providers
 */
abstract class CloudService
{

    /**
     * Create a new CloudService for the given provider
     *
     * @param string     $provider
     * @param Credential $credentials
     * @param string     $region
     * @return CloudService
     * @throws UnknownProviderException
     */
    public static function createCloudService($provider, Credential $credentials, $region = null)
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
     * @var Credential
     */
    protected $credentials;

    /**
     * @var string
     */
    protected $region = null;


    function __construct(Credential $credentials = null, $region = null)
    {
        $this->setCredentials($credentials);

        if ($region !== null) {
            $this->region = $region;
        }
    }

    /**
     * Get the instance manager for this provider
     *
     * @return InstanceManager
     */
    abstract public function getInstanceManager();

    /**
     * Get the resource manager for this provider
     *
     * @return ResourceManager
     */
    abstract public function getResourceManager();

    /**
     * Get the load-balancer manager for this provider
     *
     * @return LoadBalancerManager
     */
    abstract public function getLoadBalanacerManager();

    // --

    /**
     * Set Credentials
     *
     * @param Credential $credentials
     * @return CloudService
     */
    public function setCredentials(Credential $credentials)
    {
        $this->credentials = $credentials;

        if ($this->credentials instanceof RegionAwareCredential) {
            $this->setRegion($this->credentials->getRegion());
        }

        return $this;
    }

    /**
     * Get Credentials
     *
     * @return Credential
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


}
 