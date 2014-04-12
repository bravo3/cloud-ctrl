<?php
namespace Bravo3\CloudCtrl\Tests\Resources;

use Bravo3\CloudCtrl\Interfaces\Credentials\CredentialInterface;
use Bravo3\NetworkProxy\NetworkProxyInterface;

/**
 * Settings required for live integration testing
 *
 * @see properties.dist.php
 */
class TestProperties
{
    protected function __construct() {}

    protected static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    // Amazon Web Services

    /**
     * @return CredentialInterface
     */
    public function getAwsCredentials()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getAwsTestBucket()
    {
        return 'php-cloud-controller';
    }

    // Google

    /**
     * @return CredentialInterface
     */
    public function getGoogleCredentials()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getGoogleTestBucket()
    {
        return 'php-cloud-controller';
    }

    // Common

    /**
     * @return NetworkProxyInterface
     */
    public function getProxy()
    {
        return null;
    }
}
 