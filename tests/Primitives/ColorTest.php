<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Primitives;

use Exception;
use PHPUnit\Framework\TestCase;
use function random_int;

class ColorTest extends TestCase
{
    /**
     * @var float
     */
    private $red;
    
    /**
     * @var float
     */
    private $green;
    
    /**
     * @var float
     */
    private $blue;
    
    
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->red   = random_int(0, 100) / 100;
        $this->green = random_int(0, 100) / 100;
        $this->blue  = random_int(0, 100) / 100;
    }
    
    
    public function testProvidedColorValues(): void
    {
        $color = new Color($this->red, $this->green, $this->blue);
        
        $this->assertSame($this->red, $color->red());
        $this->assertSame($this->green, $color->green());
        $this->assertSame($this->blue, $color->blue());
    }
    
    
    public function testCreatesNewColorByAddingAColor(): void
    {
        $color1 = new Color(1.0, 2.0, 3.0);
        $color2 = new Color($this->red, $this->green, $this->blue);
        
        $actualColor = $color1->plusColor($color2);
        
        $this->assertInstanceOf(Color::class, $actualColor);
        $this->assertSame(1 + $this->red, $actualColor->red());
        $this->assertSame(2 + $this->green, $actualColor->green());
        $this->assertSame(3 + $this->blue, $actualColor->blue());
    }
    
    
    public function testCreatesNewColorBySubtractingAColor(): void
    {
        $color1 = new Color(1.0, 2.0, 3.0);
        $color2 = new Color($this->red, $this->green, $this->blue);
        
        $actualColor = $color1->minusColor($color2);
        
        $this->assertInstanceOf(Color::class, $actualColor);
        $this->assertSame(1 - $this->red, $actualColor->red());
        $this->assertSame(2 - $this->green, $actualColor->green());
        $this->assertSame(3 - $this->blue, $actualColor->blue());
    }
    
    
    /**
     * @throws Exception
     */
    public function testCreatesNewColorByMultiplyingWithAScalar(): void
    {
        $color  = new Color($this->red, $this->green, $this->blue);
        $scalar = random_int(0, 100) / 100;
        
        $actualColor = $color->multiplyWithScalar($scalar);
        
        $this->assertInstanceOf(Color::class, $actualColor);
        $this->assertSame($scalar * $this->red, $actualColor->red());
        $this->assertSame($scalar * $this->green, $actualColor->green());
        $this->assertSame($scalar * $this->blue, $actualColor->blue());
    }
    
    
    /**
     * @throws Exception
     */
    public function testCreatesNewColorByMultiplyingWithAColor(): void
    {
        $color1 = new Color(1.0, 2.0, 3.0);
        $color2 = new Color($this->red, $this->green, $this->blue);
        
        $actualColor = $color1->multiplyWithColor($color2);
        
        $this->assertInstanceOf(Color::class, $actualColor);
        $this->assertSame(1.0 * $this->red, $actualColor->red());
        $this->assertSame(2.0 * $this->green, $actualColor->green());
        $this->assertSame(3.0 * $this->blue, $actualColor->blue());
    }
}
