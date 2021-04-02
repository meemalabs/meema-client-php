<?php

namespace Meema\MeemaApi\Response;

use Meema\MeemaApi\Traits\ForwardsCalls;

class Response
{
    use ForwardsCalls;

    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }
    /**
     * Dynamically handle calls into the query instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->api, $method, $parameters);
    }
}
