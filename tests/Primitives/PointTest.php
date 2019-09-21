<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use Exception;
use PHPUnit\Framework\TestCase;
use function random_int;

class PointTest extends TestCase
{
    /**
     * @var float
     */
    private $x;
    
    /**
     * @var float
     */
    private $y;
    
    /**
     * @var float|int float
     */
    private $z;
    
    
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->x = random_int(100, 10000) / 100;
        $this->y = random_int(100, 10000) / 100;
        $this->z = random_int(100, 10000) / 100;
    }
    
    
    public function testCanBeCreatedAsTuple(): void
    {
        $point = new Point($this->x, $this->y, $this->z);
        
        $this->assertInstanceOf(Tuple::class, $point);
        $this->assertSame($this->x, $point->x());
        $this->assertSame($this->y, $point->y());
        $this->assertSame($this->z, $point->z());
    }
    
    
    public function testCreatesANewPointByAddingAVector(): void
    {
        $point  = new Point(1.0, 2.0, 3.0);
        $vector = new Vector($this->x, $this->y, $this->z);
        
        $actualPoint = $point->plusVector($vector);
        
        $this->assertInstanceOf(Point::class, $actualPoint);
        $this->assertSame(1 + $this->x, $actualPoint->x());
        $this->assertSame(2 + $this->y, $actualPoint->y());
        $this->assertSame(3 + $this->z, $actualPoint->z());
    }
    
    
    public function testCreatesANewPointBySubtractingAVector(): void
    {
        $point  = new Point(1.0, 2.0, 3.0);
        $vector = new Vector($this->x, $this->y, $this->z);
        
        $actualPoint = $point->minusVector($vector);
        
        $this->assertInstanceOf(Point::class, $actualPoint);
        $this->assertSame(1 - $this->x, $actualPoint->x());
        $this->assertSame(2 - $this->y, $actualPoint->y());
        $this->assertSame(3 - $this->z, $actualPoint->z());
    }
    
    
    public function testCreatesANewVectorBySubtractingAPoint(): void
    {
        $point1 = new Point(1.0, 2.0, 3.0);
        $point2 = new Point($this->x, $this->y, $this->z);
        
        $actualVector = $point1->minusPoint($point2);
        
        $this->assertInstanceOf(Vector::class, $actualVector);
        $this->assertSame(1 - $this->x, $actualVector->x());
        $this->assertSame(2 - $this->y, $actualVector->y());
        $this->assertSame(3 - $this->z, $actualVector->z());
    }
}
