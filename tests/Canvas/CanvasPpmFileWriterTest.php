<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Canvas;

use ItsAMirko\RayTracer\Primitives\Color;
use League\Flysystem\FilesystemInterface;
use PHPUnit\Framework\TestCase;
use function explode;
use const PHP_EOL;

class CanvasPpmFileWriterTest extends TestCase
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;
    
    /**
     * @var CanvasPpmFileWriter
     */
    private $fileWriter;
    
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->filesystem = $this->createMock(FilesystemInterface::class);
        
        $this->fileWriter = new CanvasPpmFileWriter($this->filesystem);
    }
    
    
    public function testWritesPPMHeader(): void
    {
        $expectedFilename     = 'my_canvas.ppm';
        $expectedContentLines = [
            0 => 'P3',
            1 => '5 3',
            2 => '255',
        ];
        
        $this->filesystem->expects($this->once())
                         ->method('put')
                         ->with($expectedFilename, $this->checkFileContentCallback($expectedContentLines));
        
        $canvas = new Canvas(5, 3);
        $this->fileWriter->createFile($canvas, $expectedFilename);
    }
    
    
    public function testWritesPixels(): void
    {
        $expectedFilename     = 'my_canvas.ppm';
        $expectedContentLines = [
            3 => '255 0 0 0 0 0 0 0 0 0 0 0 0 0 0',
            4 => '0 0 0 0 0 0 0 128 0 0 0 0 0 0 0',
            5 => '0 0 0 0 0 0 0 0 0 0 0 0 0 0 255',
        ];
        
        $this->filesystem->expects($this->once())
                         ->method('put')
                         ->with($expectedFilename, $this->checkFileContentCallback($expectedContentLines));
        
        $canvas = new Canvas(5, 3);
        $canvas->addPixel(0, 0, new Color(1.5, 0.0, 0.0));
        $canvas->addPixel(2, 1, new Color(0.0, 0.5, 0.0));
        $canvas->addPixel(4, 2, new Color(-0.5, 0.0, 1.0));
        
        $this->fileWriter->createFile($canvas, $expectedFilename);
    }
    
    
    public function testSplitsLongLinesOfPixels(): void
    {
        $expectedFilename     = 'my_canvas.ppm';
        $expectedContentLines = [
            3 => '255 204 153 255 204 153 255 204 153 255 204 153 255 204 153 255 204',
            4 => '153 255 204 153 255 204 153 255 204 153 255 204 153',
            5 => '255 204 153 255 204 153 255 204 153 255 204 153 255 204 153 255 204',
            6 => '153 255 204 153 255 204 153 255 204 153 255 204 153',
        ];
        
        $this->filesystem->expects($this->once())
                         ->method('put')
                         ->with($expectedFilename, $this->checkFileContentCallback($expectedContentLines));
        
        $canvas = new Canvas(10, 2);
        for ($i = 0; $i < 10; $i++) {
            $canvas->addPixel($i, 0, new Color(1, 0.8, 0.6));
            $canvas->addPixel($i, 1, new Color(1, 0.8, 0.6));
        }
        
        $this->fileWriter->createFile($canvas, $expectedFilename);
    }
    
    
    /**
     * Returns a callback to check the content of the PPM file
     *
     * @param array $expectedContentLines
     *
     * @return callable
     */
    private function checkFileContentCallback(array $expectedContentLines)
    {
        return $this->callback(function (
            string $content
        ) use ($expectedContentLines): bool {
            $actualContentLines = explode(PHP_EOL, $content);
            foreach ($expectedContentLines as $line => $expectedContent) {
                if ($expectedContent !== $actualContentLines[$line]) {
                    return false;
                }
            }
            
            return true;
        });
    }
}
