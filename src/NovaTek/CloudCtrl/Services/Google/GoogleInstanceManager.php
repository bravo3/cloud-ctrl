<?php
namespace NovaTek\CloudCtrl\Services\Google;

use NovaTek\CloudCtrl\Entity\Google\GoogleCredential;
use NovaTek\CloudCtrl\Exceptions\InvalidCredentialsException;
use NovaTek\CloudCtrl\Filters\InstanceFilter;
use NovaTek\CloudCtrl\Reports\InstanceProvisionReport;
use NovaTek\CloudCtrl\Schema\InstanceSchema;
use NovaTek\CloudCtrl\Services\Common\InstanceManager;

/**
 *
 */
class GoogleInstanceManager extends InstanceManager
{
    /**
     * Create new instances
     *
     * @param int            $count
     * @param InstanceSchema $schema
     * @return InstanceProvisionReport
     */
    public function createInstances($count, InstanceSchema $schema)
    {
        $credentials = $this->getCloudService()->getCredentials();

        if (!($credentials instanceof GoogleCredential)) {
            throw new InvalidCredentialsException("Invalid credentials: expected 'GoogleCredential'");
        }

        if (!file_exists($credentials->getPrivateKeyFile())) {
            throw new InvalidCredentialsException("Private key file does not exist: ".
                                                  $credentials->getPrivateKeyFile());
        }

        $scope = array('https://www.googleapis.com/auth/compute');

        $client = new \Google_Client();
        $client->setApplicationName($credentials->getApplicationName());

        // If we have a token saved (see below) - set it here to avoid re-requesting it
        $token = null;
        if ($token) {
            $client->setAccessToken($token);
        }

        // Load the key in PKCS 12 format (you need to download this from the Google API Console when the service
        // account was created.
        $key = file_get_contents($credentials->getPrivateKeyFile());
        //$private_key_password = 'notasecret'; // Not sure if this is abstracted by the Google SDK, or just not required

        $client->setAssertionCredentials(
            new \Google_Auth_AssertionCredentials($credentials->getSecret(), $scope, $key)
        );
        $client->setClientId($credentials->getIdentity());
        $service = new \Google_Service_Compute($client);

        // This will generate the access token if required
        $out = $service->instances->listInstances($credentials->getProjectId(), $schema->getZones()[0]);

        // Save token here
        $access_token_json = $client->getAccessToken();
        if ($access_token_json) {
            $access_token_obj     = json_decode(($access_token_json));
            $access_token         = $access_token_obj->access_token;
            $access_token_expires = new \DateTime(date('c', time() + $access_token_obj->expires_in));
        }

        return $out;
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

    public function describeInstances(InstanceFilter $instances)
    {
        // TODO: Implement describeInstances() method.
    }

    public function setInstanceTags($tags, InstanceFilter $instances)
    {
        // TODO: Implement setInstanceTags() method.
    }


}
 