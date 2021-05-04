<?php

namespace Meema\MeemaClient\Functions;

use Meema\MeemaClient\Client;
use Meema\MeemaClient\Traits\DetectsFeature;
use Meema\MeemaClient\Traits\UrlResponse;

class Image
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
     * Set the image width.
     *
     * @param int $value
     *
     * @return $this
     */
    public function w($value)
    {
        $this->args = array_merge($this->args, ['w' => $value]);

        return $this;
    }

    /**
     * Set the image height value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function h($value)
    {
        $this->args = array_merge($this->args, ['h' => $value]);

        return $this;
    }

    /**
     * Set the image quality value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function q($value)
    {
        $this->args = array_merge($this->args, ['q' => $value]);

        return $this;
    }

    /**
     * Set the image blur value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function blur($value)
    {
        $this->args = array_merge($this->args, ['blur' => $value]);

        return $this;
    }

    /**
     * Determine if image is nsfw.
     *
     * @param int|string $value
     *
     * @return $this
     */
    public function nsfw($value)
    {
        $this->args = array_merge($this->args, ['nsfw' => $value]);

        return $this;
    }

    /**
     * Set image background value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function bg($value)
    {
        $this->args = array_merge($this->args, ['bg' => $value]);

        return $this;
    }

    /**
     * Set the aspect ratio value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function ar($value)
    {
        $this->args = array_merge($this->args, ['ar' => $value]);

        return $this;
    }

    /**
     * Set the brightness value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function bri($value)
    {
        $this->args = array_merge($this->args, ['bri' => $value]);

        return $this;
    }

    /**
     * Set the hue shift value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function hue($value)
    {
        $this->args = array_merge($this->args, ['hue' => $value]);

        return $this;
    }

    /**
     * Set the saturation value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function sat($value)
    {
        $this->args = array_merge($this->args, ['sat' => $value]);

        return $this;
    }

    /**
     * Set the sharpen value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function sharp($value)
    {
        $this->args = array_merge($this->args, ['sharp' => $value]);

        return $this;
    }

    /**
     * Set the border radius outer value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function pad($value)
    {
        $this->args = array_merge($this->args, ['pad' => $value]);

        return $this;
    }

    /**
     * Set the greyscale value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function greyscale($value)
    {
        $this->args = array_merge($this->args, ['greyscale' => $value]);

        return $this;
    }

    /**
     * Set the trim value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function trim($value)
    {
        $this->args = array_merge($this->args, ['trim' => $value]);

        return $this;
    }

    /**
     * Set the face index value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function faceindex($value)
    {
        $this->args = array_merge($this->args, ['faceindex' => $value]);

        return $this;
    }

    /**
     * Set the fill color value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function fillColor($value)
    {
        $this->args = array_merge($this->args, ['fill-color' => $value]);

        return $this;
    }

    /**
     * Set the fill value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function fill($value)
    {
        $this->args = array_merge($this->args, ['fill-color' => $value]);

        return $this;
    }

    /**
     * Set the color space value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function cs($value)
    {
        $this->args = array_merge($this->args, ['cs' => $value]);

        return $this;
    }

    /**
     * Set the device pixel ration value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function dpr($value)
    {
        $this->args = array_merge($this->args, ['dpr' => $value]);

        return $this;
    }

    /**
     * Set the extend value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function extend($value)
    {
        $this->args = array_merge($this->args, ['extend' => $value]);

        return $this;
    }

    /**
     * Set the extract value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function extract($value)
    {
        $this->args = array_merge($this->args, ['extract' => $value]);

        return $this;
    }

    /**
     * Set the crop value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function crop($value)
    {
        $this->args = array_merge($this->args, ['crop' => $value]);

        return $this;
    }

    /**
     * Set the max height value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function maxH($value)
    {
        $this->args = array_merge($this->args, ['max-h' => $value]);

        return $this;
    }

    /**
     * Set the min height value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function minH($value)
    {
        $this->args = array_merge($this->args, ['min-h' => $value]);

        return $this;
    }

    /**
     * Set the max width value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function maxW($value)
    {
        $this->args = array_merge($this->args, ['max-w' => $value]);

        return $this;
    }

    /**
     * Set the min width value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function minW($value)
    {
        $this->args = array_merge($this->args, ['min-w' => $value]);

        return $this;
    }

    /**
     * Set the resize fit mode value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function fit($value)
    {
        $this->args = array_merge($this->args, ['fit' => $value]);

        return $this;
    }

    /**
     * Set the pixellate value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function px($value)
    {
        $this->args = array_merge($this->args, ['px' => $value]);

        return $this;
    }
}
