<?php

namespace App\Service;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Message\WarmupCache;
use Symfony\Component\Messenger\MessageBusInterface;

class LiipCacheManager {

    public function __construct(private MessageBusInterface $messageBus, private CacheManager $cacheManager)
    {
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
