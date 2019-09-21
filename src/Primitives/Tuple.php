<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use InvalidArgumentException;

/**
 * Class Tuple
 *
 * @package ItsAMirko\RayTracer\Primitives
 */
class Tuple
{
    /**
     * @var float
     */
    protected $x;
    
    /**
     * @var float
     */
    protected $y;
    
    /**
     * @var float
     */
    protected $z;
    
    
    /**
     * Tuple constructor.
     *
     * @param float $x
     * @param float $y
     * @param float $z
     */
    public function __construct(float $x, float $y, float $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }
    
    
    /**
     * @return float
     */
    public function x(): float
    {
        return $this->x;
    }
    
    
    /**
     * @return float
     */
    public function y(): float
    {
        return $this->y;
    }
    
    
    /**
     * @return float
     */
    public function z(): float
    {
        return $this->z;
    }
    
    
    /**
     * @return Tuple
     */
    public function negate(): Tuple
    {
        return new static(-1 * $this->x, -1 * $this->y, -1 * $this->z);
    }
    
    
    /**
     * @param float $multiplier
     *
     * @return Tuple
     */
    public function multiplyWith(float $multiplier): Tuple
    {
        return new static($multiplier * $this->x, $multiplier * $this->y, $multiplier * $this->z);
    }
    
    
    /**
     * @param float $divider
     *
     * @return Tuple
     */
    public function divideWith(float $divider): Tuple
    {
        if ($divider === 0.0) {
            throw new InvalidArgumentException('Can not divided with zero');
        }
        
        return new static($this->x / $divider, $this->y / $divider, $this->z / $divider);
    }
}