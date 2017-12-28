<?php

namespace RuCenterApi\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use RuCenterApi\Manager;
use PHPUnit\Framework\TestCase;

class GetExpiringDomainsTest extends TestCase
{
    public function testExpiringDomains()
    {
        $d = new Manager('370/NIC-REG', 'dogovor');
        $result = $d->getExpiringDomains();
        $this->assertGreaterThan(1, count($result));
    }
}
