<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    public function testFailAssertArrayHasKey()
    {
        $dummy = new App\Dummy();

        $this->assertArrayHasKey('foo', $dummy::getConfigArray());
    }

    public function testPassAssertArrayHasKey()
    {
        $dummy = new App\Dummy();

        $this->assertArrayHasKey('storage', $dummy::getConfigArray());
    }

    public function testAssertClassHasAttribute()
    {
        $this->assertClassHasAttribute('foo', App\Dummy::class);
        $this->assertClassHasAttribute('bar', App\Dummy::class);
    }

    public function testAssertArraySubset()
    {
        $dummy = new App\Dummy();

        $this->assertArraySubset(['storage' => ['failed-test'], $dummy::getConfigArray()]);
    }

    public function testAssertClassHasStaticAttribute()
    {
        $this->assertClassHasStaticAttribute('availableLocales', App\Dummy::class);
    }

    public function testAssertContains()
    {
        $this->assertContains(4, [1, 2, 3]);
    }

    public function testAssertContainsOnly()
    {
        $this->assertContainsOnly('string', ['1', '2', 3]);
    }

    public function testAssertContainsOnlyInstancesOf()
    {
        $this->assertContainsOnlyInstancesOf(
            Foo::class,
            [new Foo, new Bar, new Foo]
        );
    }

    public function testAssertRegExp()
    {
        $this->assertRegExp('/^CODE\-\d{2,7}[A-Z]$/', App\Dummy::getRandomCode());
    }

}
