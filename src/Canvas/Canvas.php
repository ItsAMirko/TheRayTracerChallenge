<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Canvas;

use ItsAMirko\RayTracer\Primitives\Color;
use OutOfBoundsException;

class Canvas
{
    /**
     * @var int
     */
    private $width;
    
    /**
     * @var int
     */
    private $height;
    
    /**
     * @var Color[][]
     */
    private $pixels;
    
    
    /**
     * Canvas constructor.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width  = $width;
        $this->height = $height;
    }
    
    
    /**
     * @return int
     */
    public function width(): int
    {
        return $this->width;
    }
    
    
    /**
     * @return int
     */
    public function height(): int
    {
        return $this->height;
    }
    
    
    /**
     * @return Color[][]
     */
    public function pixels(): array
    {
        return $this->pixels;
    }
    
    
    /**
     * @param int   $x
     * @param int   $y
     * @param Color $color
     */
    public function addPixel(int $x, int $y, Color $color): void
    {
        if ($x < 0 || $x >= $this->width) {
            throw new OutOfBoundsException('Invalid position for x provided. Expected integer between 0 and '
                                           . ($this->width - 1) . ', but got ' . $x);
        } elseif ($y < 0 || $y >= $this->height) {
            throw new OutOfBoundsException('Invalid position for y provided. Expected integer between 0 and '
                                           . ($this->height - 1) . ', but got ' . $y);
        }
        
        $this->pixels[$x][$y] = $color;
    }
}