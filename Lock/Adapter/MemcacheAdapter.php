<?php

/*
 * This file is part of the PerbilityDistributedLockBundle package. (c) PERBILITY GmbH <http://www.perbility.de> For the
 * full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace Perbility\Bundle\LockBundle\Lock\Adapter;

use Memcache;

/**
 * A distributed lock-adapter built ontop of Memcache
 * 
 * @author "Benjamin Zikarsky <benjamin.zikarsky@perbility.de>"
 */
class MemcacheAdapter implements AdapterInterface
{
    /**
     *  Default timeout before acquiration is retried in ms
     */
    const DEFAULT_TIMEOUT = 20;
    
    /**
     * @var Memcache
     */
    protected $memcache;
    
    /**
     * @var int
     */
    protected $retryTimeout;
    
    /**
     * Creates a distributed lock adapter with an memcached backend
     * 
     * The adapter ist built ontop of Memcache::add, which is non-blocking. To emulate
     * a blocking behaviour a retryTimeout can bet set
     * 
     * @param Memcache $memcache
     * @param int $retryTimeout defaults to DEFAULT_TIMEOUT
     */
    public function __construct(Memcache $memcache, $retryTimeout = self::DEFAULT_TIMEOUT)
    {
        $this->memcache = $memcache;
        $this->retryTimeout = $retryTimeout;
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\DistributedLockBundle\Lock\Adapter\AdapterInterface::acquire()
     */
    public function acquire($name, $blocking = true)
    {
        while (!($acquired = $this->memcache->add($name, true)) && $blocking) {
            // @codeCoverageIgnoreStart
            usleep($this->retryTimeout);
        }
        // @codeCoverageIgnoreEnd
        
        return $acquired;
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\DistributedLockBundle\Lock\Adapter\AdapterInterface::release()
     */
    public function release($name)
    {
        $this->memcache->delete($name);
    }
    
    /*
     * (non-PHPdoc) @see \Perbility\Bundle\DistributedLockBundle\Lock\Adapter\AdapterInterface::isLocked()
     */
    public function isLocked($name)
    {
        return (bool) $this->memcache->get($name);
    }
}
