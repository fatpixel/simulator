<?php

namespace SimpleZoo\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;

class PlatesServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
      Engine::class
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share(Engine::class, function () {
            $engine = new Engine(__DIR__ . '/../Templates');

            return $engine;
        });
    }
}
