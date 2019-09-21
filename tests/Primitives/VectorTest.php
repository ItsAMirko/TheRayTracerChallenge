<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use Exception;
use PHPUnit\Framework\TestCase;
use function random_int;

class VectorTest extends TestCase
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
        $vector = new Vector($this->x, $this->y, $this->z);
        
        $this->assertInstanceOf(Tuple::class, $vector);
        $this->assertSame($this->x, $vector->x());
        $this->assertSame($this->y, $vector->y());
        $this->assertSame($this->z, $vector->z());
    }
    
    
    public function testCreatesANewPointByAddingAPoint(): void
    {
        $vector = new Vector(1.0, 2.0, 3.0);
        $point  = new Point($this->x, $this->y, $this->z);
        
        $actualPoint = $vector->plusPoint($point);
        
        $this->assertInstanceOf(Point::class, $actualPoint);
        $this->assertSame(1 + $this->x, $actualPoint->x());
        $this->assertSame(2 + $this->y, $actualPoint->y());
        $this->assertSame(3 + $this->z, $actualPoint->z());
    }
    
    
    public function testCreatesANewVectorByAddingAVector(): void
    {
        $vector1 = new Vector(1.0, 2.0, 3.0);
        $vector2 = new Vector($this->x, $this->y, $this->z);
        
        $actualVector = $vector1->plusVector($vector2);
        
        $this->assertInstanceOf(Vector::class, $actualVector);
        $this->assertSame(1 + $this->x, $actualVector->x());
        $this->assertSame(2 + $this->y, $actualVector->y());
        $this->assertSame(3 + $this->z, $actualVector->z());
    }
    
    
    public function testCreatesANewVectorBySubtractingAVector(): void
    {
        $vector1 = new Vector(1.0, 2.0, 3.0);
        $vector2 = new Vector($this->x, $this->y, $this->z);
        
        $actualVector = $vector1->minusVector($vector2);
        
        $this->assertInstanceOf(Vector::class, $actualVector);
        $this->assertSame(1 - $this->x, $actualVector->x());
        $this->assertSame(2 - $this->y, $actualVector->y());
        $this->assertSame(3 - $this->z, $actualVector->z());
    }
    
    
    public function testCreatesANewPointBySubtractingAPoint(): void
    {
        $vector = new Vector(1.0, 2.0, 3.0);
        $point  = new Point($this->x, $this->y, $this->z);
        
        $actualPoint = $vector->minusPoint($point);
        
        $this->assertInstanceOf(Point::class, $actualPoint);
        $this->assertSame(1 - $this->x, $actualPoint->x());
        $this->assertSame(2 - $this->y, $actualPoint->y());
        $this->assertSame(3 - $this->z, $actualPoint->z());
    }
    
    
    /**
     * @dataProvider parametersForMagnitudes
     *
     * @param Vector $vector
     * @param float  $expectedMagnitude
     */
    public function testHasAMagnitude(Vector $vector, float $expectedMagnitude): void
    {
        $this->assertSame($expectedMagnitude, $vector->magnitude());
    }
    
    
    /**
     * @return array
     */
    public function parametersForMagnitudes(): array
    {
        return [
            [new Vector(1.0, 0.0, 0.0), 1.0],
            [new Vector(0.0, 1.0, 0.0), 1.0],
            [new Vector(0.0, 0.0, 1.0), 1.0],
            [new Vector(1.0, 2.0, 3.0), sqrt(14)],
            [new Vector(-1.0, -2.0, -3.0), sqrt(14)],
        ];
    }
    
    
    /**
     * @dataProvider parametersForNormalization
     *
     * @param Vector $vector
     * @param Vector $expectedVector
     */
    public function testCanBeNormalized(Vector $vector, Vector $expectedVector): void
    {
        $normalizedVector = $vector->normalize();
        
        $this->assertSame($expectedVector->x(), $normalizedVector->x());
        $this->assertSame($expectedVector->y(), $normalizedVector->y());
        $this->assertSame($expectedVector->z(), $normalizedVector->z());
        $this->assertSame(1.0, $normalizedVector->magnitude());
    }
    
    
    /**
     * @return array
     */
    public function parametersForNormalization(): array
    {
        return [
            [
                new Vector(4.0, 0.0, 0.0),
                new Vector(1.0, 0.0, 0.0),
            ],
            [
                new Vector(1.0, 2.0, 3.0),
                new Vector(1 / sqrt(14), 2 / sqrt(14), 3 / sqrt(14)),
            ],
        ];
    }
    
    
    public function testCanBuildDotProduct(): void
    {
        $vector1 = new Vector(1.0, 2.0, 3.0);
        $vector2 = new Vector(2.0, 3.0, 4.0);
        
        $this->assertSame(20.0, $vector1->dot($vector2));
    }
    
    
    /**
     * @dataProvider parametersForVectorCrossProduct
     *
     * @param Vector $vector1
     * @param Vector $vector2
     * @param Vector $expectedVector
     */
    public function testCanBuildCrossProduct(Vector $vector1, Vector $vector2, Vector $expectedVector): void
    {
        $actualTuple = $vector1->cross($vector2);
        
        $this->assertSame($expectedVector->x(), $actualTuple->x());
        $this->assertSame($expectedVector->y(), $actualTuple->y());
        $this->assertSame($expectedVector->z(), $actualTuple->z());
    }
    
    
    /**
     * @return array
     */
    public function parametersForVectorCrossProduct(): array
    {
        return [
            [
                new Vector(1.0, 2.0, 3.0),
                new Vector(2.0, 3.0, 4.0),
                new Vector(-1.0, 2.0, -1.0),
            ],
            [
                new Vector(2.0, 3.0, 4.0),
                new Vector(1.0, 2.0, 3.0),
                new Vector(1.0, -2.0, 1.0),
            ],
        ];
    }
}
