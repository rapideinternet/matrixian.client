<?php

namespace RapideInternet\Matrixian\Clients\Interfaces;

interface Response {

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return array|null
     */
    public function getBody(): ?array;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return bool
     */
    public function isPaginatedResponse(): bool;
}
