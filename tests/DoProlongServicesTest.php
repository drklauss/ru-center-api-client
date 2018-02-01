<?php

namespace RuCenterApi\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use RuCenterApi\entities\ProlongDomain;
use RuCenterApi\Manager;
use PHPUnit\Framework\TestCase;

class DoProlongServicesTest extends TestCase
{
    public function testExpiringDomains()
    {
        $d = new Manager('370/NIC-REG', 'dogovor');
        $prolongDomain = new ProlongDomain();
        $prolongDomain->domain = 'TEST-DOMAIN.RU';
        $prolongDomain->subjectContract = '370/NIC-REG';
        $result = $d->prolongDomain($prolongDomain);
        $this->assertEquals(402, $result);
    }
}
