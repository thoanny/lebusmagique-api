<?php

namespace App\Service;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class ImageEncoded
{

    private CacheManager $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function get($icon = null, $path = null, $filter = null): ?string
    {
        if($icon === null || $path === null || $filter === null) {
            return null;
        }

        $url = $this->cacheManager->getBrowserPath($path.$icon, $filter);
        $u = parse_url($url);
        $data = @file_get_contents(trim($u['path'], '/'));

        if(!$data) {
            return null;
        }

        $type = pathinfo($url, PATHINFO_EXTENSION);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
