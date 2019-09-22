<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use ItsAMirko\RayTracer\Canvas\Canvas;
use ItsAMirko\RayTracer\Canvas\CanvasPpmFileWriter;
use ItsAMirko\RayTracer\Primitives\Color;
use ItsAMirko\RayTracer\Primitives\Point;
use ItsAMirko\RayTracer\Primitives\Vector;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Class Projectile
 */
class Projectile
{
    /**
     * @var Point
     */
    public $position;
    
    /**
     * @var Vector
     */
    public $velocity;
}

/**
 * Class Environment
 */
class Environment
{
    /**
     * @var Vector
     */
    public $gravity;
    
    /**
     * @var Vector
     */
    public $wind;
}

function tick(Environment $environment, Projectile $projectile): Projectile
{
    $projectile->position = $projectile->position->plusVector($projectile->velocity);
    $projectile->velocity = $projectile->velocity->plusVector($environment->gravity)->plusVector($environment->wind);
    
    return $projectile;
}

$environment          = new Environment();
$environment->gravity = new Vector(0.0, -0.1, 0.0);
$environment->wind    = new Vector(-0.01, 0.0, 0.0);

$projectile           = new Projectile();
$projectile->position = new Point(0.0, 1.0, 0.0);
$projectile->velocity = (new Vector(1.0, 1.8, 0.0))->normalize()->multiplyWith(11.25);

$canvas = new Canvas(900, 550);
$color  = new Color(0.0, 1.0, 0.0);

while ($projectile->position->y() > 0) {
    $canvas->addPixel((int)$projectile->position->x(), 550 - (int)$projectile->position->y(), $color);
    tick($environment, $projectile);
}

$adapter      = new Local(__DIR__ . '/../images');
$filesystem   = new Filesystem($adapter);
$canvasWriter = new CanvasPpmFileWriter($filesystem);
$canvasWriter->createFile($canvas, 'virtual_cannon.ppm');