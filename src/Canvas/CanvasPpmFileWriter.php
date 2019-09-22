<?php

declare(strict_types=1);

namespace ItsAMirko\RayTracer\Canvas;

use League\Flysystem\FilesystemInterface;
use function strlen;
use const PHP_EOL;

/**
 * Class CanvasPpmFileWriter
 *
 * @package ItsAMirko\RayTracer\Canvas
 */
class CanvasPpmFileWriter
{
    /**
     * Defines the maximal number of chars per line in the file.
     */
    private const MAX_CHARS_PER_LINE = 70;
    
    /**
     * @var FilesystemInterface
     */
    private $filesystem;
    
    
    /**
     * CanvasFileWriter constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
    
    
    /**
     * @param Canvas $canvas
     * @param string $filename
     */
    public function createFile(Canvas $canvas, string $filename): void
    {
        $content = $this->getFileHeader($canvas);
        $content .= $this->getImageContent($canvas);
        
        $this->filesystem->put($filename, $content);
    }
    
    
    /**
     * @param Canvas $canvas
     *
     * @return string
     */
    private function getFileHeader(Canvas $canvas): string
    {
        return 'P3' . PHP_EOL . $canvas->width() . ' ' . $canvas->height() . PHP_EOL . '255' . PHP_EOL;
    }
    
    
    /**
     * @param Canvas $canvas
     *
     * @return string
     */
    private function getImageContent(Canvas $canvas): string
    {
        $content = '';
        $pixels  = $canvas->pixels();
        
        for ($y = 0; $y < $canvas->height(); $y++) {
            $rowContent = '';
            for ($x = 0; $x < $canvas->width(); $x++) {
                foreach (['red', 'green', 'blue'] as $color) {
                    $colorHex = '0';
                    if (isset($pixels[$x][$y]) && $color === 'red') {
                        $colorHex = $pixels[$x][$y]->redAsHex();
                    } elseif (isset($pixels[$x][$y]) && $color === 'green') {
                        $colorHex = $pixels[$x][$y]->greenAsHex();
                    } elseif (isset($pixels[$x][$y]) && $color === 'blue') {
                        $colorHex = $pixels[$x][$y]->blueAsHex();
                    }
                    
                    if (strlen($rowContent . $colorHex) > self::MAX_CHARS_PER_LINE) {
                        $content    .= trim($rowContent) . PHP_EOL;
                        $rowContent = '';
                    }
                    $rowContent .= $colorHex . ' ';
                }
            }
            $content .= trim($rowContent) . PHP_EOL;
        }
        
        return $content;
    }
}