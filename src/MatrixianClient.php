<?php

namespace RapideInternet\Matrixian;

use Psr\Http\Message\ResponseInterface;
use RapideInternet\Matrixian\Clients\WOZClient;
use RapideInternet\Matrixian\Contracts\BaseClient;
use RapideInternet\Matrixian\Clients\AddressClient;
use RapideInternet\Matrixian\Clients\HouseDetailsClient;

class MatrixianClient extends BaseClient {

    protected string $url = 'https://api.matrixiangroup.com';
    public AddressClient $address;
    public HouseDetailsClient $houseDetails;
    public WOZClient $woz;

    /**
     * @param AddressClient $address
     * @param AuthClient $authClient
     * @param HouseDetailsClient $houseDetails
     * @param WOZClient $woz
     */
    public function __construct(
        AddressClient $address,
        AuthClient $authClient,
        HouseDetailsClient $houseDetails,
        WOZClient $woz
    ) {
        parent::__construct($authClient);
        $this->address = $address;
        $this->houseDetails = $houseDetails;
        $this->woz = $woz;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function parseBody(ResponseInterface $response): array {
        return ['data' => json_decode($response->getBody(), true)];
    }
}
