<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

/**
 * Class Point
 *
 * @package ItsAMirko\RayTracer\Primitives
 */
class Point extends Tuple
{
    /**
     * Point constructor.
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
     * @return Point
     */
    public function plusVector(Vector $vector): Point
    {
        return new Point($this->x + $vector->x(), $this->y + $vector->y(), $this->z + $vector->z());
    }
    
    
    /**
     * @param Vector $vector
     *
     * @return Point
     */
    public function minusVector(Vector $vector): Point
    {
        return new Point($this->x - $vector->x(), $this->y - $vector->y(), $this->z - $vector->z());
    }
    
    
    /**
     * @param Point $point
     *
     * @return Vector
     */
    public function minusPoint(Point $point): Vector
    {
        return new Vector($this->x - $point->x(), $this->y - $point->y(), $this->z - $point->z());
    }
    
    
}