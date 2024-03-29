<?php

namespace RapideInternet\Matrixian;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response implements Clients\Interfaces\Response {

    protected int $status_code;
    protected ?array $body;
    protected string $message;

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        $this->status_code = (int) $data['status_code'];
        $this->body = $data['body'] ?? null;
        $this->message = $data['message'] ?? '';
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        return $this->status_code;
    }

    /**
     * @return array|null
     */
    public function getBody(): ?array {
        return $this->body;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array {
        return $this->body['data'] ?? null;
    }

    /**
     * @return array|null
     */
    public function getMeta(): ?array {
        return $this->body['meta'] ?? null;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getStatus(): string {
        return $this->isValid() ? 'ok' : 'error';
    }

    /**
     * @return array
     */
    public function getMessages(): array {
        return [['status' => $this->getStatus(), 'text' => $this->message]];
    }

    /**
     * @return bool
     */
    public function isPaginatedResponse(): bool {
        return $this->getMeta() !== null && isset($this->getMeta()['pagination']);
    }

    /**
     * @return bool
     */
    public function isValid(): bool {
        return $this->getStatusCode() >= HttpResponse::HTTP_OK && $this->getStatusCode() <= HttpResponse::HTTP_IM_USED;
    }
}
