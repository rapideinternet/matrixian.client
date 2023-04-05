<?php

namespace RapideInternet\Matrixian\Contracts;

use Closure;
use Carbon\Carbon;
use RapideInternet\Matrixian\Response;
use RapideInternet\Matrixian\Interfaces;
use Illuminate\Contracts\Encryption\Encrypter;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthClient extends AbstractClient implements Interfaces\AuthClient {

    protected ?string $client_id;
    protected ?string $client_secret;
    protected ?string $url;
    protected ?string $username;
    protected ?string $password;

    protected ?string $access_token = null;
    protected ?string $refresh_token = null;
    protected ?string $expires_at = null;

    protected bool $is_authenticated = false;
    protected bool $use_refresh = false;
    protected int $refresh_counter = 0;
    protected int $refresh_tries = 1;

    protected ?Closure $callback = null;
    protected Encrypter $encrypter;

    /**
     * @param Encrypter $encrypter
     */
    public function __construct(Encrypter $encrypter) {
        parent::__construct();
        $this->encrypter = $encrypter;
    }

    /**
     * @param array $credentials
     * @return AuthClient
     */
    public function setCredentials(array $credentials): AuthClient {
        if(isset($credentials[self::USERNAME])) {
            $this->username = $credentials[self::USERNAME];
        }
        if(isset($credentials[self::PASSWORD]) && $credentials[self::PASSWORD] !== null) {
            $this->password = $this->encrypter->encrypt($credentials[self::PASSWORD]);
        }
        if(isset($credentials[self::CLIENT_ID])) {
            $this->client_id = $credentials[self::CLIENT_ID];
        }
        if(isset($credentials[self::CLIENT_SECRET])) {
            $this->client_secret = $credentials[self::CLIENT_SECRET];
        }
        if(isset($credentials[self::URL])) {
            $this->url = $credentials[self::URL];
        }
        if(isset($credentials[self::ACCESS_TOKEN])) {
            $this->access_token = $credentials[self::ACCESS_TOKEN];
        }
        if(isset($credentials[self::REFRESH_TOKEN])) {
            $this->refresh_token = $credentials[self::REFRESH_TOKEN];
        }
        if(isset($credentials[self::EXPIRES_AT])) {
            $this->expires_at = $credentials[self::EXPIRES_AT];
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool {
        return $this->is_authenticated;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool {
        if($this->expires_at === null) {
            return true;
        }
        return Carbon::createFromTimestamp($this->expires_at)->isPast();
    }

    /**
     * @return int|null
     */
    public function getExpiresAt(): ?int {
        return $this->expires_at;
    }

    /**
     * @param int $expires_in
     */
    public function setExpiresAt(int $expires_in): void {
        $this->expires_at = Carbon::now()->addSeconds($expires_in)->unix();
    }

    /**
     * @return array
     */
    public function getToken(): array {
        return [
            'access_token' => $this->getAccessToken(),
            'refresh_token' => $this->getRefreshToken(),
            'expires_at' => $this->getExpiresAt()
        ];
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string {
        return $this->access_token;
    }

    /**
     * @param $token
     * @return void
     */
    public function setAccessToken($token): void {
        $this->access_token = $token;
        $this->is_authenticated = true;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string {
        return $this->refresh_token;
    }

    /**
     * @param $token
     * @return void
     */
    public function setRefreshToken($token): void {
        $this->refresh_token = $token;
        $this->use_refresh = true;
    }

    /**
     * @return Response
     */
    public function authenticate(): Response {
        $response = parent::post('/oauth/token', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credentials'
        ]);
        $this->authRequest($response);
        return $response;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Response
     */
    public function login(string $username, string $password): Response {
        $response = parent::post('/oauth/token', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
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
        $response = parent::post('/oauth/token', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $this->getRefreshToken(),
            'grant_type' => 'refresh_token'
        ]);
        $this->authRequest($response);
        $this->fireCallback();
        return $response;
    }

    /**
     * @param Response $response
     * @return void
     */
    protected function authRequest(Response $response): void {
        $data = $response->getBody();
        if($response->getStatusCode() === HttpResponse::HTTP_OK && isset($data[self::ACCESS_TOKEN])) {
            $this->setAccessToken($data[self::ACCESS_TOKEN]);
            if(isset($data[self::REFRESH_TOKEN])) {
                $this->setRefreshToken($data[self::REFRESH_TOKEN]);
            }
            $this->setExpiresAt($data[self::EXPIRES_IN]);
        }
        else {
            if($response->getStatusCode() >= HttpResponse::HTTP_MULTIPLE_CHOICES && isset($data['error'])) {
                $this->handleError($data);
            }
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function handleError($data): void {
        if($data['error'] === 'access_denied') {
            if($this->use_refresh && ($this->refresh_counter < $this->refresh_tries)) {
                $this->refresh_counter++;
                $this->refresh();
            }
        }
    }

    /**
     * @param Closure $next
     */
    public function setRefreshCallback(Closure $next) {
        $this->callback = $next;
    }

    /**
     * @return void
     */
    protected function fireCallback(): void {
        if(is_callable($this->callback)) {
            $callback = $this->callback;
            $callback($this);
        }
    }

    /**
     * @return string
     */
    public function getURL(): string {
        return $this->url;
    }

    /**
     * @return void
     */
    protected function beforeRequest(): void {
        // No action
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return [
            'Content-Type' => 'application/json'
        ];
    }
}
