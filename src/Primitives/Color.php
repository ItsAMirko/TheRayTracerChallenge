<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

/**
 * Class Color
 *
 * @package ItsAMirko\RayTracer\Primitives
 */
class Color
{
    /**
     * @var float
     */
    private $red;
    
    /**
     * @var float
     */
    private $green;
    
    /**
     * @var float
     */
    private $blue;
    
    
    /**
     * Color constructor.
     *
     * @param float $red
     * @param float $green
     * @param float $blue
     */
    public function __construct(float $red, float $green, float $blue)
    {
        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;
    }
    
    
    /**
     * @return float
     */
    public function red(): float
    {
        return $this->red;
    }
    
    
    /**
     * @return float
     */
    public function green(): float
    {
        return $this->green;
    }
    
    
    /**
     * @return float
     */
    public function blue(): float
    {
        return $this->blue;
    }
    
    
    /**
     * @param Color $color
     *
     * @return Color
     */
    public function plusColor(Color $color): Color
    {
        return new Color($this->red + $color->red(), $this->green + $color->green(), $this->blue + $color->blue());
    }
    
    
    /**
     * @param Color $color
     *
     * @return Color
     */
    public function minusColor(Color $color): Color
    {
        return new Color($this->red - $color->red(), $this->green - $color->green(), $this->blue - $color->blue());
    }
    
    
    /**
     * @param float $multiplier
     *
     * @return Color
     */
    public function multiplyWithScalar(float $multiplier): Color
    {
        return new Color($this->red * $multiplier, $this->green * $multiplier, $this->blue * $multiplier);
    }
    
    
    /**
     * @param Color $color
     *
     * @return Color
     */
    public function multiplyWithColor(Color $color): Color
    {
        return new Color($this->red * $color->red(), $this->green * $color->green(), $this->blue * $color->blue());
    }
}