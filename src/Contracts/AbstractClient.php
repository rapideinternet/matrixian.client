<?php

namespace RapideInternet\Matrixian\Contracts;

use GuzzleHttp\Client;
use RapideInternet\Matrixian\Response;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use RapideInternet\Matrixian\Exceptions\Exception;
use RapideInternet\Matrixian\Exceptions\NotFoundException;
use RapideInternet\Matrixian\Exceptions\ForbiddenException;
use RapideInternet\Matrixian\Exceptions\BadRequestException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use RapideInternet\Matrixian\Exceptions\UnauthorizedException;
use RapideInternet\Matrixian\Exceptions\NotImplementedException;
use RapideInternet\Matrixian\Exceptions\ServiceUnavailableException;
use RapideInternet\Matrixian\Exceptions\UnprocessableEntityException;
use RapideInternet\Matrixian\Exceptions\InternalServerErrorException;

abstract class AbstractClient {

    protected Client $client;

    /**
     * Constructor
     */
    public function __construct() {
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @param array $parameters
     * @return Response
     */
    public function get(string $url, array $parameters = []): Response {
        $this->beforeRequest();
        $options['headers'] = $this->getHeaders();
        $options['query'] = $parameters;
        try {
            $response = $this->client->get($this->getURL().$url, $options);
        }
        catch(GuzzleException $e) {
            return $this->parseError($e);
        }
        return $this->parseResponse($response);
    }

    /**
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function post(string $url, array $data): Response {
        $this->beforeRequest();
        $options['headers'] = $this->getHeaders();
        $options['body'] = json_encode($data);
        try {
            $response = $this->client->post($this->getURL().$url, $options);
        }
        catch(GuzzleException $e) {
            return $this->parseError($e);
        }
        return $this->parseResponse($response);
    }

    /**
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function put(string $url, array $data): Response {
        $this->beforeRequest();
        $options['headers'] = $this->getHeaders();
        $options['body'] = json_encode($data);
        try {
            $response = $this->client->put($this->getURL().$url, $options);
        }
        catch(GuzzleException $e) {
            return $this->parseError($e);
        }
        return $this->parseResponse($response);
    }

    /**
     * @param string $url
     * @return Response
     */
    public function delete(string $url): Response {
        $this->beforeRequest();
        $options['headers'] = $this->getHeaders();
        try {
            $response = $this->client->delete($this->getURL().$url, $options);
        }
        catch(GuzzleException $e) {
            return $this->parseError($e);
        }
        return $this->parseResponse($response);
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    protected function parseResponse(ResponseInterface $response): Response {
        return new Response([
            'status_code' => $response->getStatusCode(),
            'body' => $this->parseBody($response),
            'message' => 'Query was successful'
        ]);
    }

    /**
     * @param GuzzleException $e
     * @return Response
     */
    protected function parseError(GuzzleException $e): Response {
        $exception = $this->parseException($e);
        return new Response([
            'status_code' => $exception->getStatusCode(),
            'body' => [],
            'message' => $exception->getMessage()
        ]);
    }

    /**
     * @param GuzzleException $e
     * @return Exception
     */
    protected function parseException(GuzzleException $e): Exception {
        if($e instanceof ConnectException) {
            return new ServiceUnavailableException($e);
        }
        elseif($e instanceof RequestException) {
            if(($response = $e->getResponse()) === null) {
                return new InternalServerErrorException($e);
            }
            switch($response->getStatusCode()) {
                case HttpResponse::HTTP_BAD_REQUEST:
                    return new BadRequestException($e);
                case HttpResponse::HTTP_FORBIDDEN:
                    return new ForbiddenException($e);
                case HttpResponse::HTTP_INTERNAL_SERVER_ERROR:
                    return new InternalServerErrorException($e);
                case HttpResponse::HTTP_NOT_FOUND:
                    return new NotFoundException($e);
                case HttpResponse::HTTP_SERVICE_UNAVAILABLE:
                    return new ServiceUnavailableException($e);
                case HttpResponse::HTTP_UNAUTHORIZED:
                    return new UnauthorizedException($e);
                case HttpResponse::HTTP_UNPROCESSABLE_ENTITY:
                    return new UnprocessableEntityException($e);
                default:
                    return new NotImplementedException($e);
            }
        }
        return new NotImplementedException($e);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function parseBody(ResponseInterface $response): array {
        return json_decode($response->getBody(), true);
    }

    /**
     * @return string
     */
    public abstract function getURL(): string;

    /**
     * @return void
     */
    protected abstract function beforeRequest(): void;

    /**
     * @return array
     */
    public abstract function getHeaders(): array;
}
