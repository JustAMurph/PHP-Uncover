<?php

namespace App\RouteParser;

class Route
{
    private $urls;

    private $expr;

    private $method = 'GET';

    public function __construct($expr)
    {

        $this->expr = $expr;
    }

    public function hasURL($url)
    {
        return in_array($url, $this->urls);
    }

    /**
     * @return mixed
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param mixed $url
     */
    public function addUrl($url): void
    {
        $this->urls[] = $url;
    }

    public function addUrls($urls): void
    {
        foreach($urls as $url) {
            $this->addUrl($url);
        }
    }

    /**
     * @return mixed
     */
    public function getExpr()
    {
        return $this->expr;
    }

    /**
     * @param mixed $expr
     */
    public function setExpr($expr): void
    {
        $this->expr = $expr;
    }

    public static function withUrl($expression, $url, $method='GET')
    {
        $obj = new static($expression);
        $obj->addUrl($url);
        $obj->setMethod($method);
        return $obj;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

}
