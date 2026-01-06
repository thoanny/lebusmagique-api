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

        try {
            $imagick = new \Imagick($tempPath);
        } catch (\Exception $e) {
            throw new \RuntimeException("Unknown format");
        }

        $format = strtolower($imagick->getImageFormat());
        if ($format === 'jpeg' || $format === 'jpg') {
            return new ReplacingFile($tempPath);
        }

        $imagick->setImageFormat('jpeg');
        $imagick->setImageCompressionQuality(90);

        $tmpJpeg = tempnam(sys_get_temp_dir(), 'img_jpg_');
        $imagick->writeImage($tmpJpeg);

        return new ReplacingFile($tmpJpeg);
    }
}