<?php

namespace SimpleZoo\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;

class DiactorosServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
      Response::class,
      SapiEmitter::class,
      ServerRequest::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share(Response::class);
        $this->getContainer()->share(SapiEmitter::class);
        $this->getContainer()->share(ServerRequest::class, function () {
            return ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        });
    }
}
