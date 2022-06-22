<?php

namespace RapideInternet\Matrixian\Contracts;

use Closure;
use Exception;
use RapideInternet\Matrixian\Response;
use RapideInternet\Matrixian\Interfaces\AuthClient as IAuthClient;

abstract class BaseClient extends AbstractClient {

    protected IAuthClient $auth;
    protected string $url = '';
    protected array $clients = [];

    /**
     * @param IAuthClient $authClient
     */
    public function __construct(IAuthClient $authClient) {
        parent::__construct();
        $this->auth = $authClient;
    }

    /**
     * @param Closure $next
     */
    public function setRefreshCallback(Closure $next) {
        $this->auth->setRefreshCallback($next);
    }

    /**
     * @param array $credentials
     * @return IAuthClient
     */
    public function setCredentials(array $credentials): IAuthClient {
        $credentials['url'] = $this->url;
        return $this->auth->setCredentials($credentials);
    }

    /**
     * @return Response
     */
    public function authenticate(): Response {
        return $this->auth->authenticate();
    }

    /**
     * @param string $username
     * @param string $password
     * @return Response
     */
    public function login(string $username, string $password): Response {
        return $this->auth->login($username, $password);
    }

    /**
     * @return Response
     */
    public function refresh(): Response {
        return $this->auth->refresh();
    }

    /**
     * @return array
     */
    public function getToken(): array {
        return $this->auth->getToken();
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string {
        return $this->auth->getAccessToken();
    }

    /**
     * @param $token
     * @return void
     */
    public function setRefreshToken($token): void {
        $this->auth->setRefreshToken($token);
    }

    /**
     * @return void
     */
    protected function beforeRequest(): void {
        if($this->auth->isExpired()) {
            $this->refresh();
        }
    }

    /**
     * @return string
     */
    public function getURL(): string {
        return $this->url;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array {
        if(($accessToken = $this->getAccessToken()) === null) {
            return [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json'
            ];
        }
        return [
            'Accept' => 'application/vnd.api+json',
            'Authorization' => 'Bearer '.$accessToken,
            'Content-Type' => 'application/vnd.api+json'
        ];
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($method, $arguments) {
        if(!isset($this->clients[$method]) && !method_exists($this, $method)) {
            throw new Exception("Unknown method [$method]");
        }
        elseif(method_exists($this, $method)) {
            return call_user_func([$this, $method], $arguments);
        }
        elseif(isset($this->clients[$method])) {
            return new $this->clients[$method]($this);
        }
        throw new Exception("Unknown method [$method]");
    }

    /**
     * @param $property
     * @return mixed
     * @throws Exception
     */
    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->{$property};
        }
        elseif(isset($this->clients[$property])) {
            return new $this->clients[$property]($this);
        }
        throw new Exception("Unknown property [$property]");
    }
}
