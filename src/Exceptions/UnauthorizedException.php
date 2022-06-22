<?php

namespace RapideInternet\Matrixian\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UnauthorizedException extends Exception {

    /**
     * @return int
     */
    public function getStatusCode(): int {
        return SymfonyResponse::HTTP_UNAUTHORIZED;
    }
}
