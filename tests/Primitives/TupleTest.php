<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use function sqrt;

class TupleTest extends TestCase
{
    /**
     * @testdox A tuple with w=1.0 is a point
     */
    public function testCanBeAPoint(): void
    {
        $tuple = new Tuple(4.3, -4.2, 3.1, 1.0);
        
        $this->assertSame(4.3, $tuple->x());
        $this->assertSame(-4.2, $tuple->y());
        $this->assertSame(3.1, $tuple->z());
        $this->assertSame(1.0, $tuple->w());
        $this->assertTrue($tuple->isPoint());
        $this->assertFalse($tuple->isVector());
    }
    
    
    /**
     * @testdox A tuple with w=0.0 is a vector
     */
    public function testCanBeAVector(): void
    {
        $tuple = new Tuple(4.3, -4.2, 3.1, 0.0);
        
        $this->assertSame(4.3, $tuple->x());
        $this->assertSame(-4.2, $tuple->y());
        $this->assertSame(3.1, $tuple->z());
        $this->assertSame(0.0, $tuple->w());
        $this->assertFalse($tuple->isPoint());
        $this->assertTrue($tuple->isVector());
    }
    
    
    /**
     * @testdox creates tuples with w=1
     */
    public function testCanBeCreatedAsPoint(): void
    {
        $point = Tuple::createPoint(4.0, -4.0, 3.0);
        
        $this->assertInstanceOf(Tuple::class, $point);
        $this->assertSame(4.0, $point->x());
        $this->assertSame(-4.0, $point->y());
        $this->assertSame(3.0, $point->z());
        $this->assertSame(1.0, $point->w());
    }
    
    
    /**
     * @testdox creates tuples with w=0
     */
    public function testCanBeCreatedAsVector(): void
    {
        $vector = Tuple::createVector(4.0, -4.0, 3.0);
        
        $this->assertInstanceOf(Tuple::class, $vector);
        $this->assertSame(4.0, $vector->x());
        $this->assertSame(-4.0, $vector->y());
        $this->assertSame(3.0, $vector->z());
        $this->assertSame(0.0, $vector->w());
    }
    
    
    /**
     * @testdox      Adding two tuples
     * @dataProvider parametersForTupleAddition
     *
     * @param Tuple $tuple1
     * @param Tuple $tuple2
     * @param Tuple $expectedTuple
     */
    public function testCanBeAddedTogether(Tuple $tuple1, Tuple $tuple2, Tuple $expectedTuple): void
    {
        $actualTuple = $tuple1->plus($tuple2);
        
        $this->assertSame($expectedTuple->x(), $actualTuple->x());
        $this->assertSame($expectedTuple->y(), $actualTuple->y());
        $this->assertSame($expectedTuple->z(), $actualTuple->z());
        $this->assertSame($expectedTuple->w(), $actualTuple->w());
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleAddition(): array
    {
        return [
            [
                new Tuple(3.0, -2.0, 5.0, 1.0),
                new Tuple(-2.0, 3.0, 1.0, 0.0),
                new Tuple(1.0, 1.0, 6.0, 1.0),
            ],
            [
                new Tuple(-2.0, 3.0, 1.0, 0.0),
                new Tuple(3.0, -2.0, 5.0, 1.0),
                new Tuple(1.0, 1.0, 6.0, 1.0),
            ],
            [
                new Tuple(1.1, 2.2, 3.3, 0.0),
                new Tuple(0.9, 0.8, 0.7, 0.0),
                new Tuple(2.0, 3.0, 4.0, 0.0),
            ],
            [
                new Tuple(0.9, 0.8, 0.7, 0.0),
                new Tuple(1.1, 2.2, 3.3, 0.0),
                new Tuple(2.0, 3.0, 4.0, 0.0),
            ],
        ];
    }
    
    
    /**
     * @testdox      Throw exception if two point should be added together
     */
    public function testCanNotAddPointToAnotherPoint(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $point1 = new Tuple(1.0, 1.0, 1.0, 1.0);
        $point2 = new Tuple(1.0, 1.0, 1.0, 1.0);
        
        $point1->plus($point2);
    }
    
    
    /**
     * @testdox      Subtracting two tuples
     * @dataProvider parametersForTupleSubtraction
     *
     * @param Tuple $tuple1
     * @param Tuple $tuple2
     * @param Tuple $expectedTuple
     */
    public function testCanBeSubtractedFromEachOther(Tuple $tuple1, Tuple $tuple2, Tuple $expectedTuple): void
    {
        $actualTuple = $tuple1->minus($tuple2);
        
        $this->assertSame($expectedTuple->x(), $actualTuple->x());
        $this->assertSame($expectedTuple->y(), $actualTuple->y());
        $this->assertSame($expectedTuple->z(), $actualTuple->z());
        $this->assertSame($expectedTuple->w(), $actualTuple->w());
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleSubtraction(): array
    {
        return [
            [
                new Tuple(3.0, -2.0, 5.0, 1.0),
                new Tuple(1.0, 1.0, 6.0, 1.0),
                new Tuple(2.0, -3.0, -1.0, 0.0),
            ],
            [
                new Tuple(1.0, 1.0, 6.0, 1.0),
                new Tuple(3.0, -2.0, 5.0, 1.0),
                new Tuple(-2.0, 3.0, 1.0, 0.0),
            ],
            [
                new Tuple(1.1, 2.2, 3.3, 1.0),
                new Tuple(2.0, 3.0, 4.0, 0.0),
                new Tuple(-0.9, -0.8, -0.7, 1.0),
            ],
            [
                new Tuple(0.0, 0.0, 0.0, 0.0),
                new Tuple(2.0, 3.0, 4.0, 0.0),
                new Tuple(-2.0, -3.0, -4.0, 0.0),
            ],
            [
                new Tuple(2.0, 3.0, 4.0, 0.0),
                new Tuple(0.9, 0.8, 0.7, 0.0),
                new Tuple(1.1, 2.2, 3.3, 0.0),
            ],
        ];
    }
    
    
    /**
     * @testdox Throw exception if a point should be subtracted from a vector
     */
    public function testCanNotSubtractPointFromAVector(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $point1 = new Tuple(1.0, 1.0, 1.0, 0.0);
        $point2 = new Tuple(1.0, 1.0, 1.0, 1.0);
        
        $point1->minus($point2);
    }
    
    
    /**
     * @testdox      Negating a tuple
     * @dataProvider parametersForTupleNegation
     *
     * @param Tuple $tuple1
     * @param Tuple $expectedTuple
     */
    public function testCanBeNegated(Tuple $tuple1, Tuple $expectedTuple): void
    {
        $actualTuple = $tuple1->negate();
        
        $this->assertSame($expectedTuple->x(), $actualTuple->x());
        $this->assertSame($expectedTuple->y(), $actualTuple->y());
        $this->assertSame($expectedTuple->z(), $actualTuple->z());
        $this->assertSame($expectedTuple->w(), $actualTuple->w());
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleNegation(): array
    {
        return [
            [
                new Tuple(3.0, -2.0, 5.0, 1.0),
                new Tuple(-3.0, 2.0, -5.0, -1.0),
            ],
            [
                new Tuple(-3.0, 2.0, -5.0, -1.0),
                new Tuple(3.0, -2.0, 5.0, 1.0),
            ],
            [
                new Tuple(1.1, 2.2, 3.3, 0.0),
                new Tuple(-1.1, -2.2, -3.3, 0.0),
            ],
            [
                new Tuple(-1.1, -2.2, -3.3, 0.0),
                new Tuple(1.1, 2.2, 3.3, 0.0),
            ],
        ];
    }
    
    
    /**
     * @testdox      Multiplying a tuple
     * @dataProvider parametersForTupleMultiplication
     *
     * @param Tuple $tuple1
     * @param float $multiplier
     * @param Tuple $expectedTuple
     */
    public function testCanBeMultiplied(Tuple $tuple1, float $multiplier, Tuple $expectedTuple): void
    {
        $actualTuple = $tuple1->multiplyWith($multiplier);
        
        $this->assertSame($expectedTuple->x(), $actualTuple->x());
        $this->assertSame($expectedTuple->y(), $actualTuple->y());
        $this->assertSame($expectedTuple->z(), $actualTuple->z());
        $this->assertSame($expectedTuple->w(), $actualTuple->w());
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleMultiplication(): array
    {
        return [
            [
                new Tuple(1.0, -2.0, 3.0, -4.0),
                3.5,
                new Tuple(3.5, -7.0, 10.5, -14),
            ],
            [
                new Tuple(1.0, -2.0, 3.0, -4.0),
                0.5,
                new Tuple(0.5, -1.0, 1.5, -2.0),
            ],
            [
                new Tuple(1.0, -2.0, 3.0, -4.0),
                -1,
                new Tuple(-1.0, 2.0, -3.0, 4.0),
            ],
        ];
    }
    
    
    /**
     * @testdox      Dividing a tuple
     * @dataProvider parametersForTupleDivision
     *
     * @param Tuple $tuple1
     * @param float $divider
     * @param Tuple $expectedTuple
     */
    public function testCanBeDivided(Tuple $tuple1, float $divider, Tuple $expectedTuple): void
    {
        $actualTuple = $tuple1->divideWith($divider);
        
        $this->assertSame($expectedTuple->x(), $actualTuple->x());
        $this->assertSame($expectedTuple->y(), $actualTuple->y());
        $this->assertSame($expectedTuple->z(), $actualTuple->z());
        $this->assertSame($expectedTuple->w(), $actualTuple->w());
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleDivision(): array
    {
        return [
            [
                new Tuple(1.0, -2.0, 3.0, -4.0),
                2,
                new Tuple(0.5, -1.0, 1.5, -2.0),
            ],
            [
                new Tuple(1.0, -2.0, 3.0, -4.0),
                0.5,
                new Tuple(2.0, -4.0, 6.0, -8.0),
            ],
        ];
    }
    
    
    /**
     * @testdox Computing the magnitude of a vector
     */
    public function testHasAMagnitude(): void
    {
        $this->assertSame(1.0, (new Tuple(1.0, 0.0, 0.0, 0.0))->magnitude());
        $this->assertSame(1.0, (new Tuple(0.0, 1.0, 0.0, 0.0))->magnitude());
        $this->assertSame(1.0, (new Tuple(0.0, 0.0, 1.0, 0.0))->magnitude());
        $this->assertSame(sqrt(14), (new Tuple(1.0, 2.0, 3.0, 0.0))->magnitude());
        $this->assertSame(sqrt(14), (new Tuple(-1.0, -2.0, -3.0, 0.0))->magnitude());
    }
    
    
    /**
     * @testdox Throws an exception if the magnitude should be computed for a point
     */
    public function testCanNotComputeMagnitudeForAPoint(): void
    {
        $this->expectException(RuntimeException::class);
        
        Tuple::createPoint(1.0, 0.0, 0.0)->magnitude();
    }
    
    
    /**
     * @testdox      Normalizing vector
     * @dataProvider parametersForVectorNormalization
     *
     * @param Tuple $vector
     * @param Tuple $expectedVector
     */
    public function testCanBeNormalized(Tuple $vector, Tuple $expectedVector): void
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
    public function parametersForVectorNormalization(): array
    {
        return [
            [
                Tuple::createVector(4.0, 0.0, 0.0),
                Tuple::createVector(1.0, 0.0, 0.0),
            ],
            [
                Tuple::createVector(1.0, 2.0, 3.0),
                Tuple::createVector(1 / sqrt(14), 2 / sqrt(14), 3 / sqrt(14)),
            ],
        ];
    }
    
    
    /**
     * @testdox Throws an exception if a point should be normalized
     */
    public function testCanNotNormalizeAPoint(): void
    {
        $this->expectException(RuntimeException::class);
        
        Tuple::createPoint(1.0, 0.0, 0.0)->normalize();
    }
    
    
    /**
     * @testdox The dot product of two vectors
     */
    public function testCanBuildDotProduct(): void
    {
        $vector1 = new Tuple(1.0, 2.0, 3.0, 0.0);
        $vector2 = new Tuple(2.0, 3.0, 4.0, 0.0);
        
        $this->assertSame(20.0, $vector1->dot($vector2));
    }
    
    
    /**
     * @testdox      The cross product of two vectors
     * @dataProvider parametersForVectorCrossProduct
     *
     * @param Tuple $vector1
     * @param Tuple $vector2
     * @param Tuple $expectedVector
     */
    public function testCanBuildCrossProduct(Tuple $vector1, Tuple $vector2, Tuple $expectedVector): void
    {
        $actualTuple = $vector1->cross($vector2);
        
        $this->assertSame($expectedVector->x(), $actualTuple->x());
        $this->assertSame($expectedVector->y(), $actualTuple->y());
        $this->assertSame($expectedVector->z(), $actualTuple->z());
        $this->assertSame($expectedVector->w(), $actualTuple->w());
    }
    
    
    /**
     * @return array
     */
    public function parametersForVectorCrossProduct(): array
    {
        return [
            [
                new Tuple(1.0, 2.0, 3.0, 0.0),
                new Tuple(2.0, 3.0, 4.0, 0.0),
                new Tuple(-1.0, 2.0, -1.0, 0.0),
            ],
            [
                new Tuple(2.0, 3.0, 4.0, 0.0),
                new Tuple(1.0, 2.0, 3.0, 0.0),
                new Tuple(1.0, -2.0, 1.0, 0.0),
            ],
        ];
    }
}
