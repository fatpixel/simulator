<?php

namespace SimpleZoo\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Okneloper\Session\Session;

class SessionServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
      Session::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share(Session::class, function () {

            $session = Session::newInstance();

            return $session;

        });
    }
}
