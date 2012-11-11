<?php

/*
 * This file is part of the PerbilityLockBundle package.
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
	/* 
	 * (non-PHPdoc)
     * @see \Perbility\Bundle\LockBundle\Tests\Lock\Adapter\AdapterTest::getAdapter()
     */
    protected function getAdapter()
    {
        if (!extension_loaded("memcache")) {
            $this->markTestSkipped("Memcache extension is not available");
        }
        
        $memcache = new Memcache();
        if (!$memcache->addserver("localhost", 11211)) {
            $this->markTestSkipped("Cannot establish memcache connection on localhost:11211");
        }
        
        return new MemcacheAdapter($memcache);
    }

    
}