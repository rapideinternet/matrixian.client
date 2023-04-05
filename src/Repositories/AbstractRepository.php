<?php

namespace RapideInternet\Matrixian\Repositories;

use RapideInternet\Matrixian\MatrixianClient;

abstract class AbstractRepository {

    protected MatrixianClient $matrixian;

    /**
     * @param MatrixianClient $client
     */
    public function __construct(MatrixianClient $client) {
        $this->matrixian = $client;
    }
}
