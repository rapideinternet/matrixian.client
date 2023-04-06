<?php

namespace RapideInternet\Matrixian\Clients\Interfaces;

use Closure;
use RapideInternet\Matrixian\Response;

interface ApiClient {

    /**
     * @param Closure $next
     */
    public function setRefreshCallback(Closure $next);

    /**
     * @param array $credentials
     * @return AuthClient
     */
    public function setCredentials(array $credentials): AuthClient;

    /**
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function authenticate(): Response;

    /**
     * @param string $username
     * @param string $password
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function login(string $username, string $password): Response;

    /**
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function refresh(): Response;

    /**
     * @return array
     */
    public function getToken(): array;

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * @param $token
     * @return void
     */
    public function setRefreshToken($token): void;

    /**
     * @param string $url
     * @param array $parameters
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function get(string $url, array $parameters = []): Response;

    /**
     * @param string $url
     * @param array $data
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function post(string $url, array $data): Response;

    /**
     * @param string $url
     * @param array $data
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function put(string $url, array $data): Response;

    /**
     * @param string $url
     * @return \RapideInternet\Matrixian\Clients\Interfaces\Response
     */
    public function delete(string $url): Response;

    /**
     * @return string
     */
    public function getURL(): string;

    /**
     * @return string[]
     */
    public function getHeaders(): array;
}
