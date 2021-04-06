<?php

namespace Meema\MeemaApi\Response;

use Illuminate\Support\Arr;
use Meema\MeemaApi\Traits\ForwardsCalls;

class Response
{
    use ForwardsCalls;

    /**
     * @var \Meema\MeemaApi\Client
     */
    protected $api;

    /**
     * @var array
     */
    protected $content;

    public function __construct($api, $content)
    {
        $this->api = $api;
        $this->content = $content;
    }

    /**
     * Dynamically handle calls into the query instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->api, $method, array_merge(
            Arr::wrap($this->getKey()), $parameters
        ));
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * Get the value of the response primary key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->getData($this->getKeyName());
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData($key)
    {
        return $this->getContent('data'.($key ? '.'.$key : ''));
    }

    /**
     * Get response content.
     *
     * @param  mixed $key
     * @return array
     */
    public function getContent($key = null)
    {
        if ($key) {
            return Arr::get($this->content, $key);
        }

        return $this->content;
    }

    /**
     * Get response content to array.
     *
     * @param  mixed $key
     *
     * @return array
     */
    public function toArray()
    {
       return $this->getContent();
    }
}
