<?php

namespace Zackad\PhpUnitEntityTester\Tests;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;
use Zackad\PhpUnitEntityTester\AccessorCollectionTester;
use Zackad\PhpUnitEntityTester\Fixtures\Entity\EntityForCollection;

class AccessorCollectionTesterTest extends TestCase
{
    protected $collectionTester;

    public function setup():void
    {
        $entity = new EntityForCollection();

        $this->collectionTester = new AccessorCollectionTester($entity, 'tests');
    }

    public function testSimple()
    {
        $this->collectionTester->unique(false)
            ->test('value1', 'value2');
    }

    public function testUniqueFail()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'addTest' doesn't respect unicity.");

        $this->collectionTester->unique(true)
            ->test('value1', 'value2');
    }

    public function testUnique()
    {
        $this->collectionTester->unique(true)
            ->addMethod('addTestUnique')
            ->test('value1', 'value2');
    }

    public function testNonUniqueFail()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'addTestUnique' respect unicity for nothing.");

        $this->collectionTester->unique(false)
            ->addMethod('addTestUnique')
            ->test('value1', 'value2');
    }

    public function testAddFluent()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'addTestNotFluent' is not fluent.");

        $this->collectionTester->fluent(true)
            ->addMethod('addTestNotFluent')
            ->testAdd('value1');
    }

    public function testBadAddMethod()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badAddTest' does not add data.");

        $this->collectionTester
            ->addMethod('badAddTest')
            ->testAdd('value1');
    }

    public function testRemoveFluent()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'removeTestNotFluent' is not fluent.");

        $this->collectionTester->fluent(true)
            ->removeMethod('removeTestNotFluent')
            ->testAdd('value1')
            ->testRemove('value1');
    }

    public function testBadRemoveMethod()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badRemoveTest' does not remove data.");

        $this->collectionTester
            ->removeMethod('badRemoveTest')
            ->testAdd('value1')
            ->testRemove('value1');
    }

    public function testBadRemoveMethodReset()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badRemoveTestReset' does not remove the good number of items.");

        $this->collectionTester
            ->removeMethod('badRemoveTestReset')
            ->testAdd('value1')
            ->testAdd('value2')
            ->testRemove('value1');
    }

    public function testGetMethod()
    {
        $this->collectionTester
            ->testGet();
    }

    public function testBadGetMethod()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badGetTests' must not return null.");

        $this->collectionTester
            ->getMethod('badGetTests')
            ->testGet();
    }

    public function testBadGetMethodNotCountable()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badGetCollectionNotCountable' must return an instance of interface 'Coutable'.");

        $this->collectionTester
            ->getMethod('badGetCollectionNotCountable')
            ->testGet();
    }

    public function testBadGetMethodNotTraversable()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badGetCollectionNotTraversable' must return an instance of interface 'Traversable'.");

        $this->collectionTester
            ->getMethod('badGetCollectionNotTraversable')
            ->testGet();
    }

    public function testBadGetMethodReturnNotArray()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessage("The method 'badGetMethodReturnNotArray' must return a Countable and Traversable object or an array.");

        $this->collectionTester
            ->getMethod('badGetMethodReturnNotArray')
            ->testGet();
    }
}
