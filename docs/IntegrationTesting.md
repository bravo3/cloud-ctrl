Integration Testing
===================

Live Configuration
------------------
For integration testing, you'll need to create a copy of the properties.dist.php file and name it properties.php

Using your own AWS/Google accounts, make it look something like this -

    <?php

    /**
     * Unit test properties
     *
     * To override any of the default properties, duplicate this file as 'properties.php' and replace any
     * members of the TestProperties class that you wish to change
     */
    class properties extends \Bravo3\CloudCtrl\Tests\Resources\TestProperties
    {
        public static $aws_access_key = 'AKIAIFQFZ7BAAKOGXXCA';
        public static $aws_secret = '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';

        public static $google_client_id = '958133329576-jrit03r724s4er57ujalqrac6cb264oe.apps.googleusercontent.com';
        public static $google_service_account_name = '958133329576-jrit03r724s4er57ujalqrac6cb264oe@developer.gserviceaccount.com';
        public static $google_project_id = 'php-cloud-controller';
    }

For Google, you will need to put the private key you are provided here:

    tests/Bravo3/CloudCtrl/Tests/Resources/privatekey.p12

Costly Live Tests
-----------------
Some tests will spin up real instances and will therefore induce actual cost. These tests are all in the group
'integration' and are excluded by default. All other tests that require a live connection with legitimate credentials
but do not induce costs are in the 'live' group.
