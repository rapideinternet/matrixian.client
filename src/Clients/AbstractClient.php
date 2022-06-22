<?php

namespace RapideInternet\Matrixian\Clients;

use RapideInternet\Matrixian\MatrixianClient;

class AbstractClient extends \RapideInternet\Matrixian\Contracts\AbstractClient {

    protected MatrixianClient $matrixian;

    /**
     * @param MatrixianClient $client
     */
    public function __construct(MatrixianClient $client) {
        parent::__construct();
        $this->matrixian = $client;
    }

    /**
     * @return string
     */
    public function getURL(): string {
        return $this->matrixian->getURL();
    }

    /**
     * @return void
     */
    protected function beforeRequest(): void {
        $this->matrixian->beforeRequest();
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return $this->matrixian->getHeaders();
    }
}
