<?php

namespace App\Controller\Api;

use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Gw2AuthController extends AbstractController
{

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/api/gw2/auth', name: 'app_api_gw2_auth', methods: ['POST'])]
    public function index(Request $request, HttpClientInterface $client, Api $api): JsonResponse
    {
        $clientId = $this->getParameter('gw2auth.client.id');
        $clientSecret = $this->getParameter('gw2auth.client.secret');

        $req = $api->transformJsonBody($request);
        $code = $req->get('code');
        $redirect = $req->get('redirect');
        $refresh = $req->get('refresh', false);

        try {
            if($refresh) {
                $res = $client->request('POST', 'https://gw2auth.com/oauth2/token', [
                    'body' => [
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $code,
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'redirect_uri' => $redirect,
                    ]
                ]);
            } else {
                $res = $client->request('POST', 'https://gw2auth.com/oauth2/token', [
                    'body' => [
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                        'client_id' => $clientId,
                        'client_secret' => $clientSecret,
                        'redirect_uri' => $redirect,
                    ]
                ]);
            }

            if($res->getStatusCode() !== 200) {
                return $this->json([], $res->getStatusCode());
            }
            return $this->json($res->toArray());
        } catch (TransportExceptionInterface $e) {
            return $this->json([], $e->getCode());
        }
    }
}