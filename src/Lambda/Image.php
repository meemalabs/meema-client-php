<?php

namespace Meema\MeemaClient\Lambda;

use Meema\MeemaClient\Client;

class Image
{
    /**
     * @var \Meema\MeemaClient\Client
     */
    protected $client;

    /**
     * @var int
     */
    protected $id;

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
     * Set image rotation value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function rotate($value)
    {
        $this->args = array_merge($this->args, ['rotate' => $value]);

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
    public function br($value)
    {
        $this->args = array_merge($this->args, ['br' => $value]);

        return $this;
    }

    /**
     * Set the contrast value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function con($value)
    {
        $this->args = array_merge($this->args, ['con' => $value]);

        return $this;
    }

    /**
     * Set the exposure value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function exp($value)
    {
        $this->args = array_merge($this->args, ['exp' => $value]);

        return $this;
    }

    /**
     * Set the gamma value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function gam($value)
    {
        $this->args = array_merge($this->args, ['gam' => $value]);

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
     * Set the highlight value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function high($value)
    {
        $this->args = array_merge($this->args, ['high' => $value]);

        return $this;
    }

    /**
     * Set the invert value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function invert($value)
    {
        $this->args = array_merge($this->args, ['invert' => $value]);

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
     * Set the shadow value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function shad($value)
    {
        $this->args = array_merge($this->args, ['shad' => $value]);

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
     * Set the unsharp mask value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function usm($value)
    {
        $this->args = array_merge($this->args, ['usm' => $value]);

        return $this;
    }

    /**
     * Set the unsharp mask radius value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function usmrad($value)
    {
        $this->args = array_merge($this->args, ['usmrad' => $value]);

        return $this;
    }

    /**
     * Set the vibrance value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function vib($value)
    {
        $this->args = array_merge($this->args, ['vib' => $value]);

        return $this;
    }

    /**
     * Set the blend value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blend($value)
    {
        $this->args = array_merge($this->args, ['blend' => $value]);

        return $this;
    }

    /**
     * Set the blend-align value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendAlign($value)
    {
        $this->args = array_merge($this->args, ['blend-align' => $value]);

        return $this;
    }

    /**
     * Set the blend-alpha value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendAlpha($value)
    {
        $this->args = array_merge($this->args, ['blend-alpha' => $value]);

        return $this;
    }

    /**
     * Set the blend-crop value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendCrop($value)
    {
        $this->args = array_merge($this->args, ['blend-crop' => $value]);

        return $this;
    }

    /**
     * Set the blend-fit value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendFit($value)
    {
        $this->args = array_merge($this->args, ['blend-fit' => $value]);

        return $this;
    }

    /**
     * Set the blend-h value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendH($value)
    {
        $this->args = array_merge($this->args, ['blend-h' => $value]);

        return $this;
    }

    /**
     * Set the blend-mode value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendMode($value)
    {
        $this->args = array_merge($this->args, ['blend-mode' => $value]);

        return $this;
    }

    /**
     * Set the blend-pad value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function blendPad($value)
    {
        $this->args = array_merge($this->args, ['blend-pad' => $value]);

        return $this;
    }

    /**
     * Set the blend-size value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function blendSize($value)
    {
        $this->args = array_merge($this->args, ['blend-size' => $value]);

        return $this;
    }

    /**
     * Set the blend-width value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function blendW($value)
    {
        $this->args = array_merge($this->args, ['blend-w' => $value]);

        return $this;
    }

    /**
     * Set the blend-x value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function blendX($value)
    {
        $this->args = array_merge($this->args, ['blend-x' => $value]);

        return $this;
    }

    /**
     * Set the blend-y value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function blendY($value)
    {
        $this->args = array_merge($this->args, ['blend-y' => $value]);

        return $this;
    }

    /**
     * Set the border size color value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function border($value)
    {
        $this->args = array_merge($this->args, ['border' => $value]);

        return $this;
    }

    /**
     * Set the border inner radius value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function borderRadiusInner($value)
    {
        $this->args = array_merge($this->args, ['border-radius-inner' => $value]);

        return $this;
    }

    /**
     * Set the border radius outer value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function borderRadius($value)
    {
        $this->args = array_merge($this->args, ['border-radius' => $value]);

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
     * Set the face index value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function facepad($value)
    {
        $this->args = array_merge($this->args, ['facepad' => $value]);

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
     * Set the chroma subsampling value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function chroma($value)
    {
        $this->args = array_merge($this->args, ['chromasub' => $value]);

        return $this;
    }

    /**
     * Set the client hints value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function ch($value)
    {
        $this->args = array_merge($this->args, ['ch' => $value]);

        return $this;
    }

    /**
     * Set the client hints value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function colorquant($value)
    {
        $this->args = array_merge($this->args, ['colorquant' => $value]);

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
     * Set the dots per inch value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function dpi($value)
    {
        $this->args = array_merge($this->args, ['dpi' => $value]);

        return $this;
    }

    /**
     * Set lossless value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function lossless($value)
    {
        $this->args = array_merge($this->args, ['lossless' => $value]);

        return $this;
    }

    /**
     * Set the output format value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function fm($value)
    {
        $this->args = array_merge($this->args, ['fm' => $value]);

        return $this;
    }

    /**
     * Set the flop value.
     *
     * @param bool $value
     *
     * @return $this
     */
    public function flop($value)
    {
        $this->args = array_merge($this->args, ['flop' => $value]);

        return $this;
    }

    /**
     * Set the automatic value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function auto($value)
    {
        $this->args = array_merge($this->args, ['auto' => $value]);

        return $this;
    }

    /**
     * Set the expiration automatic value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function expires($value)
    {
        $this->args = array_merge($this->args, ['expires' => $value]);

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
     * Set the mask corner radius.
     *
     * @param string $value
     *
     * @return $this
     */
    public function cornerRadius($value)
    {
        $this->args = array_merge($this->args, ['corner-radius' => $value]);

        return $this;
    }

    /**
     * Set the mask corner radius.
     *
     * @param string $value
     *
     * @return $this
     */
    public function mask($value)
    {
        $this->args = array_merge($this->args, ['mask' => $value]);

        return $this;
    }

    /**
     * Set the noise reduction value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function nr($value)
    {
        $this->args = array_merge($this->args, ['nr' => $value]);

        return $this;
    }

    /**
     * Set the noise reduction sharpen value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function nrs($value)
    {
        $this->args = array_merge($this->args, ['nrs' => $value]);

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
     * Set the flip axis value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function flip($value)
    {
        $this->args = array_merge($this->args, ['flip' => $value]);

        return $this;
    }

    /**
     * Set the orientation value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function orient($value)
    {
        $this->args = array_merge($this->args, ['orient' => $value]);

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
    public function minw($value)
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
     * Set the source rectangle region value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function rect($value)
    {
        $this->args = array_merge($this->args, ['rect' => $value]);

        return $this;
    }

    /**
     * Set the duotone value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function duotone($value)
    {
        $this->args = array_merge($this->args, ['duotone' => $value]);

        return $this;
    }

    /**
     * Set the duotone-alpha value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function duotoneAlpha($value)
    {
        $this->args = array_merge($this->args, ['duotone-alpha' => $value]);

        return $this;
    }

    /**
     * Set the halftone value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function halftone($value)
    {
        $this->args = array_merge($this->args, ['halftone' => $value]);

        return $this;
    }

    /**
     * Set the halftone value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function monochrome($value)
    {
        $this->args = array_merge($this->args, ['monochrome' => $value]);

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

    /**
     * Set the sepia value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function sepia($value)
    {
        $this->args = array_merge($this->args, ['sepia' => $value]);

        return $this;
    }

    /**
     * Set the text align value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txtAlign($value)
    {
        $this->args = array_merge($this->args, ['txt-align' => $value]);

        return $this;
    }

    /**
     * Set the text clipping mode value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txtClip($value)
    {
        $this->args = array_merge($this->args, ['txt-clip' => $value]);

        return $this;
    }

    /**
     * Set the text color value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txtColor($value)
    {
        $this->args = array_merge($this->args, ['txt-color' => $value]);

        return $this;
    }

    /**
     * Set the text fit mode value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txtFit($value)
    {
        $this->args = array_merge($this->args, ['txt-fit' => $value]);

        return $this;
    }

    /**
     * Set the text font value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txtFont($value)
    {
        $this->args = array_merge($this->args, ['txt-font' => $value]);

        return $this;
    }

    /**
     * Set the text font size value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function txtSize($value)
    {
        $this->args = array_merge($this->args, ['txt-size' => $value]);

        return $this;
    }

    /**
     * Set the text ligatures value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function txtLig($value)
    {
        $this->args = array_merge($this->args, ['txt-lig' => $value]);

        return $this;
    }

    /**
     * Set the text outline value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function txtLine($value)
    {
        $this->args = array_merge($this->args, ['txt-line' => $value]);

        return $this;
    }

    /**
     * Set the text outline color value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txtLineColor($value)
    {
        $this->args = array_merge($this->args, ['txt-line-color' => $value]);

        return $this;
    }

    /**
     * Set the text padding value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function txtPad($value)
    {
        $this->args = array_merge($this->args, ['txt-pad' => $value]);

        return $this;
    }

    /**
     * Set the text shadow value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function txtShad($value)
    {
        $this->args = array_merge($this->args, ['txt-shad' => $value]);

        return $this;
    }

    /**
     * Set the text string value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function txt($value)
    {
        $this->args = array_merge($this->args, ['txt' => $value]);

        return $this;
    }

    /**
     * Set the text width value.
     *
     * @param int $value
     *
     * @return $this
     */
    public function txtWidth($value)
    {
        $this->args = array_merge($this->args, ['txt-width' => $value]);

        return $this;
    }

    /**
     * Convert all parameters to string url.
     *
     * @return string
     */
    public function toUrl()
    {
        $queryParams = '';

        $index = 0;

        foreach ($this->args as $key => $param) {
            $separator = '?';

            if ($index) {
                $separator = '&';
            }

            $queryParams .= "{$separator}{$key}={$param}";

            $index++;
        }

        return "https://dev-ops.mee.ma/glenn/1/5/people.jpg{$queryParams}";
    }
}
