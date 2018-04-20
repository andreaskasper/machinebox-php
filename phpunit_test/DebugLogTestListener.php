<?php
/**
 *
 *
 * PHP version 5.5.
 */

namespace machinebox-php\Test;

class DebugLogTestListener extends \PHPUnit_Framework_BaseTestListener
{
    private static $debugLog = '';

    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        echo self::$debugLog;
    }

    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        echo self::$debugLog;
    }

    public function startTest(\PHPUnit_Framework_Test $test)
    {
        self::$debugLog = '';
    }

    public static function debugLog($str)
    {
        self::$debugLog .= $str . PHP_EOL;
    }
}