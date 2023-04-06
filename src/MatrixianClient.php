<?php

namespace RapideInternet\Matrixian;

use Psr\Http\Message\ResponseInterface;
use RapideInternet\Matrixian\Clients\Contracts\BaseClient;
use RapideInternet\Matrixian\Models\Interfaces\HouseDetails;
use RapideInternet\Matrixian\Clients\Implementation\WOZClient;
use RapideInternet\Matrixian\Clients\Implementation\AddressClient;
use RapideInternet\Matrixian\Clients\Implementation\HouseDetailsClient;

class MatrixianClient extends BaseClient {

    protected string $url = 'https://api.matrixiangroup.com';
    private ?AddressClient $addressClient = null;
    private ?HouseDetailsClient $houseDetailsClient = null;
    private ?WOZClient $wozClient = null;

    /**
     * @param AuthClient $authClient
     */
    public function __construct(AuthClient $authClient) {
        parent::__construct($authClient);
    }

    /**
     * @return AddressClient
     */
    public function address(): AddressClient {
        if($this->addressClient === null) {
            $this->addressClient = new AddressClient($this);
        }
        return $this->addressClient;
    }

    /**
     * @return WozClient
     */
    public function woz(): WozClient {
        if($this->wozClient === null) {
            $this->wozClient = new WOZClient($this);
        }
        return $this->wozClient;
    }

    /**
     * @return HouseDetailsClient
     */
    public function houseDetails(): HouseDetailsClient {
        if($this->houseDetailsClient === null) {
            $this->houseDetailsClient = new HouseDetailsClient($this);
        }
        return $this->houseDetailsClient;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function parseBody(ResponseInterface $response): array {
        return ['data' => json_decode($response->getBody(), true)];
    }
}
