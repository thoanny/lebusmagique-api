<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;

class ImageFromUrlUploader
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function downloadToTempFile(string $url): ?File
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tempPath, $response->getContent());

        return new ReplacingFile($tempPath);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \ImagickException
     */
    public function downloadToTempFileAndConvertToJPG(string $url): ?ReplacingFile
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            return null;
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tempPath, $response->getContent());

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tempPath);

        $image = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($tempPath),
            'image/png'  => imagecreatefrompng($tempPath),
            'image/gif'  => imagecreatefromgif($tempPath),
            'image/webp' => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($tempPath) : null,
            'image/avif' => function_exists('imagecreatefromavif') ? imagecreatefromavif($tempPath) : null,
            default      => null,
        };

        if(!$image) {
            return null;
        }

        $tmpJpeg = tempnam(sys_get_temp_dir(), 'img_jpg_');
        imagejpeg($image, $tmpJpeg, 90);
        imagedestroy($image);

        return new ReplacingFile($tmpJpeg);
    }
}