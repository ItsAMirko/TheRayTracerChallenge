<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Canvas;

use Exception;
use ItsAMirko\RayTracer\Primitives\Color;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use function random_int;

class CanvasTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testProvidesDimensions(): void
    {
        $width  = random_int(1, 100);
        $height = random_int(1, 100);
        
        $canvas = new Canvas($width, $height);
        
        $this->assertSame($width, $canvas->width());
        $this->assertSame($height, $canvas->height());
    }
    
    
    public function testProvidesItsPixels(): void
    {
        $canvas = new Canvas(2, 2);
        $canvas->addPixel(0, 0, new Color(1.0, 0.0, 0.0));
        $canvas->addPixel(0, 1, new Color(0.0, 1.0, 0.0));
        $canvas->addPixel(1, 1, new Color(0.0, 0.0, 1.0));
        
        $expectedPixels = [
            0 => [
                0 => new Color(1.0, 0.0, 0.0),
                1 => new Color(0.0, 1.0, 0.0),
            ],
            1 => [
                1 => new Color(0.0, 0.0, 1.0),
            ],
        ];
        
        $this->assertEquals($expectedPixels, $canvas->pixels());
    }
    
    
    public function testThrowsExceptionIfPixelToAddIsOutOfBounds(): void
    {
        $this->expectException(OutOfBoundsException::class);
        
        $canvas = new Canvas(1, 1);
        $canvas->addPixel(1, 1, new Color(1.0, 0.0, 0.0));
    }
}
