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

use Perbility\Bundle\LockBundle\Lock\Adapter\MemcachedAdapter;
use Memcached;

/**
 * MemcacheAdapter Test
 * 
 * @author "Benjamin Zikarsky <benjamin.zikarsky@perbility.de>"
 */
class MemcachedAdapterTest extends AdapterTest
{
	/* 
	 * (non-PHPdoc)
     * @see \Perbility\Bundle\LockBundle\Tests\Lock\Adapter\AdapterTest::getAdapter()
     */
    protected function getAdapter()
    {
        if (!extension_loaded("memcached")) {
            $this->markTestSkipped("Memcached extension is not available");
        }
        
        $memcached = new Memcached();
        if (!$memcached->addserver("localhost", 11211)) {
            $this->markTestSkipped("Cannot establish memcache connection on localhost:11211");
        }
        return new MemcachedAdapter($memcached);
    }

    
}