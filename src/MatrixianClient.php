<?php

namespace RapideInternet\Matrixian;

use Psr\Http\Message\ResponseInterface;
use RapideInternet\Matrixian\Clients\WOZClient;
use RapideInternet\Matrixian\Contracts\BaseClient;
use RapideInternet\Matrixian\Clients\AddressClient;
use RapideInternet\Matrixian\Clients\HouseDetailsClient;

class MatrixianClient extends BaseClient {

    protected string $url = 'https://api.matrixiangroup.com';
    protected array $clients = [
        'address' => AddressClient::class,
        'houseDetails' => HouseDetailsClient::class,
        'woz' => WOZClient::class
    ];

    /**
     * @param AuthClient $authClient
     */
    public function __construct(AuthClient $authClient) {
        parent::__construct($authClient);
    }

    /**
     * @override
     * @param ResponseInterface $response
     * @return Response
     */
    protected function parseResponse(ResponseInterface $response): Response {
        return new Response([
            'status_code' => $response->getStatusCode(),
            'body' => ['data' => json_decode($response->getBody(), true)],
            'message' => 'Query was successful'
        ]);
    }
}
