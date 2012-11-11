<?php

/*
 * This file is part of the PerbilityLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Perbility\Bundle\LockBundle\Lock\Adapter;

interface AdapterInterface
{
    
    public function acquire($name, $blocking = true);
    
    public function release($name);
    
    public function isLocked($name);
    
}