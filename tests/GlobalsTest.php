<?php
namespace JoshCanHelp\Auth0\PHP\Tests;

use PHPUnit\Framework\TestCase;

class GlobalsTest extends TestCase
{
    protected $backupGlobalsBlacklist = ['banana'];

    public function testGlobalSetting() {
        $this->assertFalse( isset( $GLOBALS['banana'] ) );
        $GLOBALS['banana'] = 1;
        $this->assertTrue( isset( $GLOBALS['banana'] ) );
        $this->assertEquals( 1, $GLOBALS['banana'] );
    }

    public function testGlobalGetting() {
        $this->assertEquals( 1, $GLOBALS['banana'] );
    }
}