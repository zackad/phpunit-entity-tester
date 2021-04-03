<?php

namespace Zackad\PhpUnitEntityTester\Tests;

use PHPUnit\Framework\AssertionFailedError;
use Zackad\PhpUnitEntityTester\AccessorTester;
use Zackad\PhpUnitEntityTester\Fixtures\Entity\Entity;

class AccessorTesterTest extends \PHPUnit\Framework\TestCase
{
    protected $accessorTester;

    public function setup():void
    {
        $entity = new Entity();

        $this->accessorTester = new AccessorTester($entity, 'name');
    }

    public function testSimple()
    {
        $this->accessorTester->test('foo')
            ->test('bar')
            ;
    }

    public function testSetFluent()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage('The method \'setNameNotFluent\' is not fluent.');

        $this->accessorTester->setterMethod('setNameNotFluent')
            ->test('foo');
    }

    public function testSetNotFluent()
    {
        $this->accessorTester->fluent(false)
            ->test('foo');
    }

    public function testGetterSpecial()
    {
        $entity = new Entity();

        $nameTester = new AccessorTester($entity, 'name');
        $nameTester->getterMethod('getSpecialName')
            ->test('foo', 'fooSpecial')
            ;
    }

    public function testBadGetMethod()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectErrorMessage('The method \'badGetMethod\' does not return the good value.');

        $this->accessorTester->getterMethod('badGetMethod')
            ->test('foo');
    }
}
