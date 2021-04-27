<?php

namespace Meema\MeemaClient\Functions;

use Meema\MeemaClient\Client;
use Meema\MeemaClient\Traits\DetectsFeature;
use Meema\MeemaClient\Traits\UrlResponse;

class Video
{
    use UrlResponse, DetectsFeature;

    /**
     * @var \Meema\MeemaClient\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $args = [];

    /**
     * Construct media model.
     *
     * @param Meema\MeemaClient\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set the video thumbnail value.
     *
     * @param string|bool $value
     *
     * @return $this
     */
    public function thumbnails($value)
    {
        $this->args = array_merge($this->args, ['thumbnails' => $value]);

        return $this;
    }

    /**
     * Set the video hls value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function hls($value)
    {
        $this->args = array_merge($this->args, ['hls' => $value]);

        return $this;
    }

    /**
     * Set the video dash value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function dash($value)
    {
        $this->args = array_merge($this->args, ['dash' => $value]);

        return $this;
    }

    /**
     * Set the video poster value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function poster($value)
    {
        $this->args = array_merge($this->args, ['dash' => $value]);

        return $this;
    }

    /**
     * Set the video webvtt value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function webvtt($value)
    {
        $this->args = array_merge($this->args, ['webvtt' => $value]);

        return $this;
    }

    /**
     * Set the video format value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function format($value)
    {
        $this->args = array_merge($this->args, ['format' => $value]);

        return $this;
    }

    /**
     * Set the video web optimized value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function webOptimized($value)
    {
        $this->args = array_merge($this->args, ['web-optimized' => $value]);

        return $this;
    }
}
