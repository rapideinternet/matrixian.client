<?php

namespace RapideInternet\Matrixian\Repositories;

use RapideInternet\Matrixian\MatrixianClient;

abstract class AbstractRepository {

    protected MatrixianClient $matrixian;

    /**
     * @param MatrixianClient $matrixianClient
     */
    public function __construct(MatrixianClient $matrixianClient) {
        $this->matrixian = $matrixianClient;
    }
}
