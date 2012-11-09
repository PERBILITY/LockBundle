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

use Perbility\Bundle\LockBundle\Lock\Adapter\MemcacheAdapter;
use Memcache;

/**
 * MemcacheAdapter Test
 * 
 * @author "Benjamin Zikarsky <benjamin.zikarsky@perbility.de>"
 */
class MemcacheAdapterTest extends AdapterTest
{
    
    /**
     * Memcache instance
     * 
     * @var \Memcache
     */
    protected $memcache;
    
	public function setUp() 
	{
		if (!extension_loaded("memcache")) {
		    $this->markTestSkipped("Memcache extension is not available");
		}
		
		$this->memcache = new Memcache();
		if (!$this->memcache->addserver("localhost")) {
			$this->markTestSkipped("Cannot establish memcache connection on localhost:11211");
		}
		
		parent::setUp();
	}

    
	/* 
	 * (non-PHPdoc)
     * @see \Perbility\Bundle\LockBundle\Tests\Lock\Adapter\AdapterTest::getAdapter()
     */
    protected function getAdapter()
    {
        return new MemcacheAdapter($this->memcache);
    }

    
}