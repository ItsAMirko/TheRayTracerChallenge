<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

/**
 * Class Vector
 *
 * @package ItsAMirko\RayTracer\Primitives
 */
class Vector extends Tuple
{
    /**
     * Vector constructor.
     *
     * @param float $x
     * @param float $y
     * @param float $z
     */
    public function __construct(float $x, float $y, float $z)
    {
        parent::__construct($x, $y, $z);
    }
    
    
    /**
     * @param Vector $vector
     *
     * @return Vector
     */
    public function plusVector(Vector $vector): Vector
    {
        return new Vector($this->x + $vector->x(), $this->y + $vector->y(), $this->z + $vector->z());
    }
    
    
    /**
     * @param Point $vector
     *
     * @return Point
     */
    public function plusPoint(Point $vector): Point
    {
        return new Point($this->x + $vector->x(), $this->y + $vector->y(), $this->z + $vector->z());
    }
    
    
    /**
     * @param Vector $vector
     *
     * @return Vector
     */
    public function minusVector(Vector $vector): Vector
    {
        return new Vector($this->x - $vector->x(), $this->y - $vector->y(), $this->z - $vector->z());
    }
    
    
    /**
     * @param Point $point
     *
     * @return Point
     */
    public function minusPoint(Point $point): Point
    {
        return new Point($this->x - $point->x(), $this->y - $point->y(), $this->z - $point->z());
    }
    
    
    /**
     * @return float
     */
    public function magnitude(): float
    {
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
     * @param Vector $vector
     *
     * @return float
     */
    public function dot(Vector $vector): float
    {
        return $this->x * $vector->x() + $this->y * $vector->y() + $this->z * $vector->z;
    }
    
    
    /**
     * @param Vector $vector
     *
     * @return Vector
     */
    public function cross(Vector $vector): Vector
    {
        return new Vector($this->y * $vector->z() - $this->z * $vector->y,
            $this->z * $vector->x() - $this->x * $vector->z, $this->x * $vector->y() - $this->y * $vector->x);
    }
    
}