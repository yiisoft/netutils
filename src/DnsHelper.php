<?php

namespace Yiisoft\NetworkUtilities;

class DnsHelper
{
    /**
     * @param string $hostname hostname without dot at end
     * @link https://bugs.php.net/bug.php?id=78008
     */
    public static function existsMx(string $hostname): bool
    {
        $hostname = rtrim($hostname, '.') . '.';
        try {
            if (!@dns_check_record($hostname, 'MX')) {
                return false;
            }
            $result = @dns_get_record($hostname, DNS_MX);
            return $result !== false && count($result) > 0;
        } catch (\Throwable $t) {
            // eg. name servers are not found https://github.com/yiisoft/yii2/issues/17602
        }
        return false;
    }

    /**
     * @link https://bugs.php.net/bug.php?id=78008
     */
    public static function existsA(string $hostname): bool
    {
        try {
            if (!@dns_check_record($hostname, 'A')) {
                return false;
            }
            $result = @dns_get_record($hostname, DNS_A);
            return $result !== false && count($result) > 0;
        } catch (\Throwable $t) {
            // eg. name servers are not found https://github.com/yiisoft/yii2/issues/17602
        }
        return false;
    }

    /**
     * @link https://tools.ietf.org/html/rfc5321#section-5
     */
    public static function acceptsEmails(string $hostnameOrEmail): bool
    {
        if (strpos($hostnameOrEmail, '@') !== false) {
            [$void, $hostnameOrEmail] = explode('@', $hostnameOrEmail, 2);
        }
        return self::existsMx($hostnameOrEmail) || self::existsA($hostnameOrEmail);
    }
}
