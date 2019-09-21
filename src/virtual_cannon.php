<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use ItsAMirko\RayTracer\Primitives\Tuple;

/**
 * Class Projectile
 */
class Projectile
{
    /**
     * @var Tuple
     */
    public $position;
    
    /**
     * @var Tuple
     */
    public $velocity;
}

/**
 * Class Environment
 */
class Environment
{
    /**
     * @var Tuple
     */
    public $gravity;
    
    /**
     * @var Tuple
     */
    public $wind;
}


function tick(Environment $environment, Projectile $projectile): Projectile
{
    $projectile->position = $projectile->position->plus($projectile->velocity);
    $projectile->velocity = $projectile->velocity->plus($environment->gravity)->plus($environment->wind);
    
    return $projectile;
}

$environment          = new Environment();
$environment->gravity = Tuple::createVector(0.0, -0.1, 0.0);
$environment->wind    = Tuple::createVector(-0.01, 0.0, 0.0);

$projectile           = new Projectile();
$projectile->position = Tuple::createPoint(0.0, 1.0, 0.0);
$projectile->velocity = Tuple::createVector(1.0, 1.0, 0.0)->normalize();

while ($projectile->position->y() > 0) {
    echo $projectile->position->x() . ' | ' . $projectile->position->y() . PHP_EOL;
    tick($environment, $projectile);
}