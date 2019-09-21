<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use ItsAMirko\RayTracer\Primitives\Point;
use ItsAMirko\RayTracer\Primitives\Vector;

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
$projectile->velocity = (new Vector(1.0, 1.0, 0.0))->normalize();

while ($projectile->position->y() > 0) {
    echo $projectile->position->x() . ' | ' . $projectile->position->y() . PHP_EOL;
    tick($environment, $projectile);
}