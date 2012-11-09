<?php

/*
 * This file is part of the PerbilityDistributedLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Tests\Lock;

use Perbility\Bundle\LockBundle\Lock\Adapter\MockAdapter;
use Perbility\Bundle\LockBundle\Lock\Lock;
use Perbility\Bundle\LockBundle\Lock\LockService;
use PHPUnit_Framework_TestCase;

class LockServiceTest extends PHPUnit_Framework_TestCase
{
    
    protected $adapter;
    protected $service;
    
    public function setUp()
    {
        $this->adapter = new MockAdapter();
        $this->service = new LockService($this->adapter);
    }
    
    public function testGetLock()
    {
        $lock = $this->service->getLock("foo", false);
        $this->assertTrue($lock instanceof Lock);
        $this->assertFalse($lock->isLocked(), "new lock is not acquired when requested");
        $this->assertEquals($lock->getName(), "foo");
        
        
        $lock2 = $this->service->getLock("bar", true);
        $this->assertTrue($lock2 instanceof Lock);
        $this->assertTrue($lock2->isLocked(), "new lock is acquired when requested");
        $this->assertEquals($lock2->getName(), "bar");
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetLockInvalidName()
    {
        $lock = $this->service->getLock("");
    }
    
    public function testGetNamespace()
    {
        $service = $this->service->getNamespace("__test");
        $this->assertStringStartsWith("__test", $service->getLock("foo")->getName());
    }
    
}