<?php
namespace NovaTek\CloudCtrl\Services\Google;

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
        $application_name     = "PHP Cloud Controller";
        $client_id            = "958633929774-jrit03r724s4er57ujvlqr4c6eb236oe.apps.googleusercontent.com";
        $service_account_name = "958633929774-jrit03r724s4er57ujvlqr4c6eb236oe@developer.gserviceaccount.com";
        $scope                = array('https://www.googleapis.com/auth/compute');

        $root_dir             = __DIR__."/../../../../../";
        $private_key_file     = $root_dir."tests/NovaTek/CloudCtrl/Tests/Resources/privatekey.p12";
        $private_key_password = 'notasecret'; // Not sure if this is abstracted by the Google SDK, or just not required

        $project = "php-cloud-controller";
        $zone    = "us-central1-a";

        $client = new \Google_Client();
        $client->setApplicationName($application_name);

        // If we have a token saved (see below) - set it here to avoid re-requesting it
        $token = null;
        if ($token) {
            $client->setAccessToken($token);
        }

        // Load the key in PKCS 12 format (you need to download this from the Google API Console when the service
        // account was created.
        $key = file_get_contents($private_key_file);

        $client->setAssertionCredentials(new \Google_Auth_AssertionCredentials($service_account_name, $scope, $key));
        $client->setClientId($client_id);
        $service = new \Google_Service_Compute($client);

        // This will generate the access token if required
        $out = $service->instances->listInstances($project, $zone);

        // Save token here
        $access_token_json = $client->getAccessToken();
        if ($access_token_json) {
            $access_token_obj = json_decode(($access_token_json));
            $access_token = $access_token_obj->access_token;
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
 