<?php

namespace App\Service;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Message\WarmupCache;
use Symfony\Component\Messenger\MessageBusInterface;

class LiipCacheManager {

    private MessageBusInterface $messageBus;
    private CacheManager $cacheManager;

    public function __construct(MessageBusInterface $messageBus, CacheManager $cacheManager)
    {
        $this->messageBus = $messageBus;
        $this->cacheManager = $cacheManager;
    }

    public function generate($path, $filters): void
    {
        $this->messageBus->dispatch(new WarmupCache($path, $filters));
    }

    public function remove($path, $filters): void
    {
        $this->cacheManager->remove($path, $filters);
    }

}
