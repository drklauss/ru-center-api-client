<?php

namespace RuCenterApi\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use RuCenterApi\entities\ProlongService;
use RuCenterApi\Manager;
use PHPUnit\Framework\TestCase;

class DoProlongServicesTest extends TestCase
{
    const NIC_LOGIN = '11915/NIC-REG';
    const NIC_PASSWORD = 'VisVoydShav5';

    public function testExpiringDomains()
    {
        $d = new Manager('370/NIC-REG', 'dogovor');
        $service = new ProlongService();
        $service->domain = 'TEST-DOMAIN.RU';
        $service->serviceId = 745684;
        $result = $d->prolongServices([$service]);
        $this->assertEquals(401, $result);
    }
}
