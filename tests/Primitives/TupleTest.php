<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use PHPUnit\Framework\TestCase;

class TupleTest extends TestCase
{
    public function testProvidedCoordinates(): void
    {
        $tuple = new Tuple(4.3, -4.2, 3.1);
        
        $this->assertSame(4.3, $tuple->x());
        $this->assertSame(-4.2, $tuple->y());
        $this->assertSame(3.1, $tuple->z());
    }
    
    
    public function testCanBeNegated(): void
    {
        $tuple = new Tuple(3.0, -2.0, 5.0);
        
        $negatedTuple = $tuple->negate();
        
        $this->assertSame(-3.0, $negatedTuple->x());
        $this->assertSame(2.0, $negatedTuple->y());
        $this->assertSame(-5.0, $negatedTuple->z());
    }
    
    
    /**
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
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleMultiplication(): array
    {
        return [
            [new Tuple(1.0, -2.0, 3.0), 3.5, new Tuple(3.5, -7.0, 10.5)],
            [new Tuple(1.0, -2.0, 3.0), 0.5, new Tuple(0.5, -1.0, 1.5)],
            [new Tuple(1.0, -2.0, 3.0), -1, new Tuple(-1.0, 2.0, -3.0)],
        ];
    }
    
    
    /**
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
    }
    
    
    /**
     * @return array
     */
    public function parametersForTupleDivision(): array
    {
        return [
            [new Tuple(1.0, -2.0, 3.0), 2, new Tuple(0.5, -1.0, 1.5)],
            [new Tuple(1.0, -2.0, 3.0), 0.5, new Tuple(2.0, -4.0, 6.0)],
        ];
    }
    
}
