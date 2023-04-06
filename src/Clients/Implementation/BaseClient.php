<?php

namespace RapideInternet\Matrixian\Clients\Implementation;

use RapideInternet\Matrixian\MatrixianClient;
use RapideInternet\Matrixian\Clients\Contracts\AbstractClient;

abstract class BaseClient extends AbstractClient {

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
