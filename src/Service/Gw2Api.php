<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class Gw2Api
{
    private string $locale = 'fr';
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function get($endpoint = null, $data = [], $attr = [], $token = null)
    {
        if (!$endpoint) {
            return false;
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
            $query = array_merge($query, ['lang' => $this->locale]);
        }

        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $this->parameterBag->get('gw2.api.url') . $endpoint, ['query' => $query]);
            if($response->getStatusCode() !== 200 && $response->getStatusCode() !== 206) {
                return false;
            }
            return $response->toArray();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getItems($ids = null)
    {
        if($ids) {
            return $this->get('/items', null, ['ids' => $ids]);
        }
        return $this->get('/items');
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

    public function getAchievements(array $achievementsIds)
    {
        $ids = join(',', $achievementsIds);
        return $this->get('/achievements', [], ['ids' => $ids]);
    }

    public function getAccountAchievement(string $token) {
        return $this->get('/account/achievements', [], [], $token);
    }

    public function getAccount(string $token) {
        return $this->get('/account', [], [], $token);
    }

    public function getGuild($id) {
        return $this->get('/guild/:id', ['id' => $id]);
    }

    public function getAccountGuildsName($ids): array
    {
        $guilds = [];

        foreach($ids as $id) {
            $guild = $this->getGuild($id);
            if($guild) {
                $guilds[] = "[{$guild['tag']}] {$guild['name']}";
            }
        }

        return $guilds;
    }
}
