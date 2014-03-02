<?php
namespace NovaTek\CloudCtrl\Tests\Credentials;

use Aws\Common\Enum\Region;
use NovaTek\CloudCtrl\Credentials\RegionAwareCredential;

class RegionAwareCredentialTest extends \PHPUnit_Framework_TestCase
{
    const TEST_IDENTITY = "test-identity";
    const TEST_SECRET = "test-secret";

    /**
     * @small
     */
    public function testProperties()
    {
        $credential = new RegionAwareCredential();
        $this->assertNull($credential->getIdentity());
        $this->assertNull($credential->getSecret());
        $this->assertNull($credential->getRegion());


        $credential->setIdentity(self::TEST_IDENTITY);
        $credential->setSecret(self::TEST_SECRET);
        $credential->setRegion(Region::SYDNEY);

        $this->assertEquals(self::TEST_IDENTITY, $credential->getIdentity());
        $this->assertEquals(self::TEST_SECRET, $credential->getSecret());

        // Region::AP_SOUTHEAST_2 == Region::SYDNEY
        $this->assertEquals(Region::AP_SOUTHEAST_2, $credential->getRegion());
    }

}
 