<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use InvalidArgumentException;
use RuntimeException;
use function pow;
use function sqrt;

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
     * @var float
     */
    protected $w;
    
    
    /**
     * Tuple constructor.
     *
     * @param float $x
     * @param float $y
     * @param float $z
     * @param float $w
     */
    public function __construct(float $x, float $y, float $z, float $w)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->w = $w;
    }
    
    
    /**
     * @param float $x
     * @param float $y
     * @param float $z
     *
     * @return Tuple
     */
    public static function createPoint(float $x, float $y, float $z): Tuple
    {
        return new self($x, $y, $z, 1.0);
    }
    
    
    /**
     * @param float $x
     * @param float $y
     * @param float $z
     *
     * @return Tuple
     */
    public static function createVector(float $x, float $y, float $z): Tuple
    {
        return new self($x, $y, $z, 0.0);
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
     * @return float
     */
    public function w(): float
    {
        return $this->w;
    }
    
    
    /**
     * @return bool
     */
    public function isPoint(): bool
    {
        return $this->w === 1.0;
    }
    
    
    /**
     * @return bool
     */
    public function isVector(): bool
    {
        return $this->w === 0.0;
    }
    
    
    /**
     * @param Tuple $other
     *
     * @return Tuple
     */
    public function plus(Tuple $other): Tuple
    {
        if ($this->isPoint() && $other->isPoint()) {
            throw new InvalidArgumentException('Two point can not be added together');
        }
        
        return new self($this->x + $other->x(), $this->y + $other->y(), $this->z + $other->z(), $this->w + $other->w());
    }
    
    
    /**
     * @param Tuple $other
     *
     * @return Tuple
     */
    public function minus(Tuple $other): Tuple
    {
        if ($this->isVector() && $other->isPoint()) {
            throw new InvalidArgumentException('Can not subtract a point from a vector');
        }
        
        return new self($this->x - $other->x(), $this->y - $other->y(), $this->z - $other->z(), $this->w - $other->w());
    }
    
    
    /**
     * @return Tuple
     */
    public function negate(): Tuple
    {
        return new self(-1 * $this->x, -1 * $this->y, -1 * $this->z, -1 * $this->w);
    }
    
    
    /**
     * @param float $multiplier
     *
     * @return Tuple
     */
    public function multiplyWith(float $multiplier): Tuple
    {
        return new self($multiplier * $this->x, $multiplier * $this->y, $multiplier * $this->z, $multiplier * $this->w);
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
        
        return new self($this->x / $divider, $this->y / $divider, $this->z / $divider, $this->w / $divider);
    }
    
    
    /**
     * @return float
     */
    public function magnitude(): float
    {
        if ($this->isVector() === false) {
            throw new RuntimeException('This tuple needs to be a vector');
        }
        
        return sqrt(pow($this->x, 2) + pow($this->y, 2) + pow($this->z, 2));
    }
    
    
    /**
     * @return Tuple
     */
    public function normalize(): Tuple
    {
        return $this->divideWith($this->magnitude());
    }
    
    
    /**
     * @param Tuple $other
     *
     * @return float
     */
    public function dot(Tuple $other): float
    {
        if ($this->isVector() === false || $other->isVector() === false) {
            throw new RuntimeException('Dot product can only be build for vectors');
        }
        
        return $this->x * $other->x() + $this->y * $other->y() + $this->z * $other->z;
    }
    
    
    /**
     * @param Tuple $other
     *
     * @return Tuple
     */
    public function cross(Tuple $other): Tuple
    {
        if ($this->isVector() === false || $other->isVector() === false) {
            throw new RuntimeException('Cross product can only be build for vectors');
        }
        
        return new self($this->y * $other->z() - $this->z * $other->y, $this->z * $other->x() - $this->x * $other->z,
            $this->x * $other->y() - $this->y * $other->x, 0.0);
    }
}