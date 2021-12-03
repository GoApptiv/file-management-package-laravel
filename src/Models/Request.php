<?php

namespace GoApptiv\FileManagement\Models;


class Request
{

    private $endpoint;
    private $method;
    private $headers = [];
    private $queryParams = [];
    private $payload = [];


    /**
     * Get the value of endpoint
     */
    public function getEndPoint()
    {
        return $this->endpoint;
    }

    /**
     * Set the value of endpoint
     *
     * @return  self
     */
    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }



    /**
     * Get the type of method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the type of method
     *
     * @return  self
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }


    /**
     * Get the value of headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of headers
     *
     * @return  self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }


    /**
     * Get the value of queryParams
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Set the value of queryParams
     *
     * @return  self
     */
    public function setQueryParams($queryParams)
    {
        $this->queryParams = $queryParams;

        return $this;
    }

    /**
     * Get the value of payload
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set the value of payload
     *
     * @return  self
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }
}