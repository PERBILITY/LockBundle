<?php

/*
 * This file is part of the PerbilityDistributedLockBundle package.
 *
 * (c) PERBILITY GmbH <http://www.perbility.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Perbility\Bundle\LockBundle\Lock\Adapter;

/**
 * A small lock implementation ontop of apc
 *  
 * @author Benjamin Zikarsky <benjamin.zikarsky@perbility.de>
 */
class ApcAdapter implements AdapterInterface
{
	/**
     * Default timeout before acquiration is retried in ms
     */
    const DEFAULT_TIMEOUT = 20;
    
    /**
     * @var int
     */
    protected $retryTimeout;
    
    /**
     * Creates a lock ontop of apc. Be aware that apc can have seperate caches foreach php worker
     * so a lock might not even by system-wide, and only limited to the process
     * 
     * @param int $retryTimeout defaults to DEFAULT_TIMEOUT
     */
    public function __construct($retryTimeout = self::DEFAULT_TIMEOUT)
    {
        $this->retryTimeout = $retryTimeout;
    }

    /*
     * (non-PHPdoc) @see \Perbility\Bundle\DistributedLockBundle\Lock\Adapter\AdapterInterface::acquire()
    */
    public function acquire($name, $blocking = false)
    {
        while (!($acquired = apc_add($name, true)) && $blocking) {
            // @codeCoverageIgnoreStart
            usleep($this->retryTimeout);
        }
        // @codeCoverageIgnoreEnd
        
        return $acquired;
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\DistributedLockBundle\Lock\Adapter\AdapterInterface::isLocked()
     */
    public function isLocked($name)
    {
    	return (bool) apc_fetch($name);  
    }

	/* 
	 * (non-PHPdoc)
     * @see \Perbility\Bundle\LockBundle\Lock\Adapter\AdapterInterface::release()
     */
    public function release($name)
    {
    	apc_delete($name);   
    }
}
