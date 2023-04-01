<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class Gw2Api
{
    private $locale = 'fr';
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function get($endpoint = null, $data = [], $attr = [], $token = null)
    {
        if (!$endpoint) {
            return;
        }

        if ($data) {
            foreach ($data as $k => $v) {
                $v = str_replace(' ', '%20', $v);
                $endpoint = str_replace(":$k", $v, $endpoint);
            }
        }

        $query = $attr;

        if ($token) {
            $query = array_merge($query, ['access_token' => $token]);
        }

        if ($this->locale) {
            $_lang = ['fr', 'en', 'de', 'es'];
            $lang = ($this->locale && in_array($this->locale, $_lang)) ? strtolower($this->locale) : 'fr';
            $query = array_merge($query, ['lang' => $lang]);
        }

        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $this->parameterBag->get('gw2.api.url') . $endpoint, ['query' => $query]);
            return $response->toArray();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getItem($uid)
    {
        return $this->get('/items/:uid', ['uid' => $uid]);
    }
}
