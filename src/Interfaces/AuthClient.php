<?php

namespace RapideInternet\Matrixian\Interfaces;

use Closure;

interface AuthClient {

    CONST USERNAME = 'username';
    CONST PASSWORD = 'password';
    CONST URL = 'url';
    CONST CLIENT_ID = 'client_id';
    CONST CLIENT_SECRET = 'client_secret';
    CONST ACCESS_TOKEN = 'access_token';
    CONST REFRESH_TOKEN = 'refresh_token';
    CONST EXPIRES_IN = 'expires_in';
    CONST EXPIRES_AT = 'expires_at';

    /**
     * @param array $credentials
     * @return AuthClient
     */
    public function setCredentials(array $credentials): AuthClient;

    /**
     * @param Closure $next
     */
    public function setRefreshCallback(Closure $next);

    /**
     * @return bool
     */
    public function isAuthenticated(): bool;

    /**
     * @return bool
     */
    public function isExpired(): bool;

    /**
     * @return int|null
     */
    public function getExpiresAt(): ?int;

    /**
     * @param int $expires_in
     */
    public function setExpiresAt(int $expires_in): void;

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
    public function setAccessToken($token): void;

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string;

    /**
     * @param $token
     * @return void
     */
    public function setRefreshToken($token): void;

    /**
     * @return Response
     */
    public function authenticate(): Response;

    /**
     * @param string $username
     * @param string $password
     * @return Response
     */
    public function login(string $username, string $password): Response;

    /**
     * @return Response
     */
    public function refresh(): Response;
}
