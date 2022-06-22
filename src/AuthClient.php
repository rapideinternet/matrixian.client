<?php

namespace RapideInternet\Matrixian;

class AuthClient extends \RapideInternet\Matrixian\Contracts\AuthClient {

    /**
     * @param string $username
     * @param string $password
     * @return Response
     */
    public function login(string $username, string $password): Response {
        $response = parent::post('/token', [
            'username' => $username,
            'password' => $password,
            'grant_type' => 'password'
        ]);
        $this->authRequest($response);
        return $response;
    }

    /**
     * @return Response
     */
    public function refresh(): Response {
        $response = parent::post('/token', [
            'username' => $this->username,
            'password' => $this->password !== null ? $this->encrypter->decrypt($this->password) : null
        ]);
        $this->authRequest($response);
        $this->fireCallback();
        return $response;
    }

    /**
     * @param int $expires_in
     */
    public function setExpiresAt(int $expires_in): void {
        $this->expires_at = $expires_in;
    }
}
