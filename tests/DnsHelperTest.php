<?php

namespace Yiisoft\NetworkUtilities\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\NetworkUtilities\DnsHelper;

/**
 * @group potentially-slow
 */
class DnsHelperTest extends TestCase
{
    private const NOT_EXISTS_DOMAIN = 'not-exist-for-ever.eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeedomain.xxxxxxxxxxxxxxxxxxxxxxx';
    private const NOT_EXISTS_DOMAIN_EMAIL = 'any@' . self::NOT_EXISTS_DOMAIN;

    public function testMx(): void
    {
        $this->assertTrue(DnsHelper::existsMx('google.com'));
        $this->assertFalse(DnsHelper::existsMx(self::NOT_EXISTS_DOMAIN));
    }

    public function testA(): void
    {
        $this->assertTrue(DnsHelper::existsA('google.com'));
        $this->assertFalse(DnsHelper::existsA(self::NOT_EXISTS_DOMAIN));
    }

    public function testAcceptsEmail(): void
    {
        $this->assertTrue(DnsHelper::acceptsEmails('google.com'));
        $this->assertTrue(DnsHelper::acceptsEmails('noreply@google.com'));
        $this->assertFalse(DnsHelper::acceptsEmails(self::NOT_EXISTS_DOMAIN));
        $this->assertFalse(DnsHelper::acceptsEmails(self::NOT_EXISTS_DOMAIN_EMAIL));
    }
}