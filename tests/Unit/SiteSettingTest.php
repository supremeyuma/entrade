<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SiteSettingTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_it_can_store_and_retrieve_settings()
{
    SiteSetting::set('test_key', 'test_value');

    $this->assertEquals('test_value', SiteSetting::get('test_key'));
}

}
