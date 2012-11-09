<?php

/*
 * This file is part of the PerbilityDistributedLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Tests\Lock\Adapter;

use Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface;
use LogicException;
use PHPUnit_Framework_TestCase;

abstract class AdapterTest extends PHPUnit_Framework_TestCase
{
    protected $adapter;
    
    abstract protected function getAdapter();
    
    public function setUp()
    {
        $adapter = $this->getAdapter();
        if (!$adapter instanceof AdapterInterface) {
            throw new LogicException("AdapterTest::getAdapter has to provide a valid AdapterInterface");
        }
        
        $this->adapter = $adapter;
        $this->adapter->release("test1");
        $this->adapter->release("test2");
        $this->adapter->release("test3");
    }
    
	protected function tearDown() 
	{
		if ($this->adapter) {
		    $this->adapter->release("test1");
		    $this->adapter->release("test2");
		    $this->adapter->release("test3");
		}
	}

    
    public function testAcquire()
    {
        $this->assertTrue($this->adapter->acquire("test1", false));
        $this->assertFalse($this->adapter->acquire("test1", false));
    }
    
    public function testRelease()
    {
        $this->adapter->acquire("test1", false);
        $this->assertFalse($this->adapter->acquire("test1", false));
        $this->adapter->release("test1");
        $this->assertTrue($this->adapter->acquire("test1", false));
    }
    
    public function testIsLocked()
    {
        $this->assertFalse($this->adapter->isLocked("test1"));
        $this->adapter->acquire("test1", false);
        $this->assertTrue($this->adapter->isLocked("test1"));
        $this->adapter->release("test1");
        $this->assertFalse($this->adapter->isLocked("test1"));
    }
    
}