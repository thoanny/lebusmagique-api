<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function Tinify\fromUrl;
use function Tinify\setKey;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;

class TinifyManager
{

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    public function convert(string $url): ?ReplacingFile
    {
        setKey($this->parameterBag->get('tinify.api.key'));

        $source = fromUrl($url);
        $converted = $source->convert(['type' => 'image/jpeg'])->transform(['background' => '#000000']);

        $tempPath = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tempPath, $converted->toBuffer());

        return new ReplacingFile($tempPath);
    }
}