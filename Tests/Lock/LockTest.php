<?php

/*
 * This file is part of the PerbilityLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Tests\Lock;

use Perbility\Bundle\LockBundle\Lock\Adapter\MockAdapter;
use Perbility\Bundle\LockBundle\Lock\Lock;
use PHPUnit_Framework_TestCase;
use stdclass;

class Locktest extends PHPUnit_Framework_TestCase
{
    protected $adapter;
    
    public function setUp()
    {
        $this->adapter = new MockAdapter();
    }
    
    public function testCreate()
    {
        $lock = new Lock("test", $this->adapter);
        $this->assertEquals($lock->getName(), "test");
        
        $this->assertFalse($lock->isLocked());
    }
    
    /**
     * @dataProvider invalidLockNames
     * @expectedException \InvalidArgumentException
     */
    public function testCreateInvalid($name)
    {
        $lock = new Lock($name, $this->adapter);
    }
    
    public function testAcquire()
    {
        $lock = new Lock("test", $this->adapter);
        $lock->acquire();
        $this->assertTrue($lock->isLocked());
        $this->assertFalse($lock->acquire(false));
    }
    
    public function testRelease()
    {
        $lock = new Lock("test", $this->adapter);
        $lock->release();
        $this->assertFalse($lock->isLocked());
        $this->assertTrue($lock->acquire(false));
        
        $lock->release();
        $this->assertFalse($lock->isLocked());
        $this->assertTrue($lock->acquire(false));
    }
    
    public function testIsLocked()
    {
        $lock = new Lock("test", $this->adapter);
        $this->assertFalse($lock->isLocked());
        $lock->acquire();
        $this->assertTrue($lock->isLocked());
        $lock->release();
        $this->assertFalse($lock->isLocked());
    }
    
    public function testGetName()
    {
        $lock = new Lock("foo", $this->adapter);
        $this->assertEquals("foo", $lock->getName());

		$mockNameObject = $this->getMock("test", ["__toString"]);
		$mockNameObject->expects($this->any())
					   ->method("__toString")
					   ->will($this->returnValue("bar"))
		;

        $lock = new Lock($mockNameObject, $this->adapter);
        $this->assertEquals("bar", $lock->getName());
        
    }
    
    public static function invalidLockNames()
    {
        return [
        	[""], [null], [new stdclass], [[]]
        ];
    }
    
}