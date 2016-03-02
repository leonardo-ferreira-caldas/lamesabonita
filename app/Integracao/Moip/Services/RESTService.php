<?php

namespace App\Integracao\Moip\Services;

use App\Integracao\Moip\Authorizations\AuthorizationInterface;
use JsonSerializable;

class RESTService implements ServiceInterface {

    /**
     * endpoint of production.
     *
     * @const string
     */
    const ENDPOINT_PRODUCTION = 'api.moip.com.br';
    /**
     * endpoint of sandbox.
     *
     * @const string
     */
    const ENDPOINT_SANDBOX = 'sandbox.moip.com.br';

    private $url;
    private $serializable;
    private $headers = [];

    public function __construct($url, JsonSerializable $serializable = null)
    {
        $this->url = $url;
        $this->serializable = $serializable;
        $this->headers['Content-Type'] = 'application/json';
    }

    public function withAuthorization(AuthorizationInterface $authorizationInterface) {
        $this->headers['Authorization'] = $authorizationInterface->getAuthorization();
    }

    public function getUrl()
    {
        return $this->getEndpointUrl();
    }

    public function getBody()
    {
        return json_encode($this->serializable);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    private function getEnvironment()
    {
        if (env("APP_ENV") == "production") {
            return self::ENDPOINT_PRODUCTION;
        }

        return self::ENDPOINT_SANDBOX;
    }

    private function getEndpointUrl()
    {
        return sprintf("%s://%s/%s", "https", $this->getEnvironment(), $this->url);
    }

}