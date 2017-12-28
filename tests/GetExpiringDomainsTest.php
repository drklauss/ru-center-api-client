<?php

namespace Ns\RuCenterApi\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use Ns\RuCenterApi\Client;
use PHPUnit\Framework\TestCase;

class GetExpiringDomainsTest extends TestCase
{
    public function testExpiringDomains()
    {
        $d = new Client('370', 'dogovor');
        $result = $d->getExpiringDomains();
        $this->assertGreaterThan(1, count($result));
    }
}
