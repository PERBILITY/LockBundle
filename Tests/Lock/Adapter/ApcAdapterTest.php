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

use Perbility\Bundle\LockBundle\Lock\Adapter\ApcAdapter;

/**
 * ApcAdapter-Test
 * 
 * @author Benjamin Zikarsky <benjamin.zikarsky@perbility.de>
 */
class ApcAdapterTest extends AdapterTest
{
	/* 
	 * (non-PHPdoc)
     * @see \Perbility\Bundle\LockBundle\Tests\Lock\Adapter\AdapterTest::getAdapter()
     */
    protected function getAdapter()
    {
        if (!extension_loaded("apc")) {
            $this->markTestSkipped("apc extension is not available");
        }
        
        return new ApcAdapter();
    }
    
}
