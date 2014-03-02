<?php
namespace NovaTek\CloudCtrl\Tests\Credentials;

use NovaTek\CloudCtrl\Credentials\Credential;

class CredentialTest extends \PHPUnit_Framework_TestCase
{
    const TEST_IDENTITY = "test-identity";
    const TEST_SECRET = "test-secret";

    /**
     * @small
     */
    public function testProperties()
    {
        $credential = new Credential();
        $this->assertNull($credential->getIdentity());
        $this->assertNull($credential->getSecret());

        $credential->setIdentity(self::TEST_IDENTITY);
        $credential->setSecret(self::TEST_SECRET);
        $this->assertEquals(self::TEST_IDENTITY, $credential->getIdentity());
        $this->assertEquals(self::TEST_SECRET, $credential->getSecret());
    }

}
 