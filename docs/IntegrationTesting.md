Integration Testing
===================

Live Configuration
------------------
For integration testing, you'll need to create a copy of the properties.dist.php file and name it properties.php

Using your own AWS/Google accounts, make it look something like this -

    <?php

    use Aws\Common\Enum\Region;
    use Bravo3\CloudCtrl\Entity\Aws\AwsCredential;
    use Bravo3\CloudCtrl\Entity\Google\GoogleCredential;
    use Bravo3\CloudCtrl\Tests\Resources\TestProperties;

    /**
     * Unit test properties
     *
     * To override any of the default properties, duplicate this file as 'properties.php' and replace any
     * members of the TestProperties class that you wish to change
     */
    class properties extends TestProperties
    {
        // AWS
        public function getAwsCredentials()
        {
            return new AwsCredential('xxxxxx', 'xxxxxxx', Region::US_EAST_1);
        }

        // Google
        public function getGoogleCredentials()
        {
            return new GoogleCredential(
                'xxxxxx-fgki3s54654654r2egip34534f445gf5.apps.googleusercontent.com',
                'xxxxxx-fgki3s54654654r2egip34534f445gf5@developer.gserviceaccount.com',
                __DIR__.'/Bravo3/CloudCtrl/Tests/Resources/privatekey.p12',
                'php-cloud-controller',
                'CloudCtrl Tests'
            );
        }

    }

For Google, you will need to put the private key you are provided in the above directory:

    tests/Bravo3/CloudCtrl/Tests/Resources/privatekey.p12

Costly Live Tests
-----------------
Some tests will spin up real instances and will therefore induce actual cost. These tests are all in the group
'integration' and are excluded by default. All other tests that require a live connection with legitimate credentials
but do not induce costs are in the 'live' group.
