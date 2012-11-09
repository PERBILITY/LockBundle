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

use Perbility\Bundle\LockBundle\Lock\Adapter\MockAdapter;

class MockAdapterTest extends AdapterTest
{
	/* (non-PHPdoc)
     * @see \Perbility\Bundle\LockBundle\Tests\Lock\Adapter\AdapterTest::getAdapter()
     */
    protected function getAdapter()
    {
        return new MockAdapter();
    }
    
}
