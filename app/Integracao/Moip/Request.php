<?php

namespace App\Integracao\Moip;

use ErrorException;
use App\Integracao\Moip\Services\ServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Log;

class Request {

    private $service;

    const RESPONSE_HTTP_CODE_OK = '200';
    const RESPONSE_HTTP_CODE_CREATED = '201';

    const METHOD_POST   = "POST";
    const METHOD_PUT    = "PUT";
    const METHOD_GET    = "GET";
    const METHOD_DELETE = "DELETE";

    public function __construct(ServiceInterface $service) {
        $this->service = $service;
    }

    private function body() {
        return [
            'headers' => $this->service->getHeaders(),
            'body' => $this->service->getBody()
        ];
    }

    public function get() {
        return $this->send(self::METHOD_GET);
    }

    public function post() {
        return $this->send(self::METHOD_POST);
    }

    public function put() {
        return $this->send(self::METHOD_PUT);
    }

    public function delete() {
        return $this->send(self::METHOD_DELETE);
    }

    private function log($method) {
        Log::info("Iniciando nova requisição.");
        Log::info("Url Serviço: " . $this->service->getUrl());
        Log::info("Body: " . print_r($this->body(), true));
        Log::info("Método: " . $method);
    }

    private function send($method) {

        try {

            $this->log($method);
            $request = new Client();

            switch ($method) {
                case self::METHOD_POST:
                    $response = $request->post($this->service->getUrl(), $this->body());
                    break;
                case self::METHOD_GET:
                    $response = $request->get($this->service->getUrl(), $this->body());
                    break;
                case self::METHOD_PUT:
                    $response = $request->put($this->service->getUrl(), $this->body());
                    break;
                case self::METHOD_DELETE:
                    $response = $request->delete($this->service->getUrl(), $this->body());
                    break;
                default:
                    throw new ErrorException("Método $method desconhecido.");
            }

            $acceptResponseCodes = [
                self::RESPONSE_HTTP_CODE_OK,
                self::RESPONSE_HTTP_CODE_CREATED,
            ];

            if (!in_array($response->getStatusCode(), $acceptResponseCodes)) {
                throw new ErrorException("Erro na requsição.");
            }

            Log::info('Resposta da Requisição:' . print_r($response->json(), true));

            return $response->json();

        } catch (RequestException $exception) {
            Log::error("Houve um erro na integração com o MOIP: " . $exception->getResponse());
            throw $exception;
        }

    }

}