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
            if($response->getStatusCode() !== 200) {
                return false;
            }
            return $response->toArray();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getItem($uid)
    {
        return $this->get('/items/:uid', ['uid' => $uid]);
    }

    public function getPrice($uid) {
        return $this->get('/commerce/prices/:id', ['id' => $uid]);
    }

    public function getRecipesByOutput( $uid ) {
        return $this->get('/recipes/search', [], ['output' => $uid]);
    }

    public function getRecipe($uid) {
        return $this->get('/recipes/:uid', ['uid' => $uid]);
    }
}
