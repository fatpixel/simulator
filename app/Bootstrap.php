<?php
namespace SimpleZoo;

use League\Container\Container;
use League\Plates\Engine;
use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteCollection;
use Okneloper\Session\Session;
use RuntimeException;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequest;

/**
 * Class Bootstrap
 * @package SimpleZoo
 */
class Bootstrap
{
    /**
     * @var
     */
    private static $application;
    /**
     * @var \League\Container\Container
     */
    private $container;
    /**
     * @var \League\Route\RouteCollection
     */
    private $routes;

    /**
     * Bootstrap constructor.
     * @param \League\Container\Container $container
     * @param \League\Route\RouteCollection $routes
     */
    private function __construct(Container $container, RouteCollection $routes)
    {
        $this->container = $container;
        $this->routes = $routes;
    }

    /**
     * @return \SimpleZoo\Bootstrap
     */
    public static function application()
    {
        /**
         * We only need one Loader object at runtime so only create it
         * if an instance does not already exist.
         */
        if (!isset(self::$application)) {

            $container = new Container();

            $container->addServiceProvider(ServiceProviders\DiactorosServiceProvider::class);
            $container->addServiceProvider(ServiceProviders\PlatesServiceProvider::class);
            $container->addServiceProvider(ServiceProviders\SessionServiceProvider::class);

            $container->add(Controllers\BaseController::class);
            $container->add(Controllers\ZooController::class)
              ->withArgument(Engine::class)
              ->withArgument(Session::class)
              ->withArgument(ServerRequest::class)
              ->withArgument(Response::class)
            ;

            $container->get(Engine::class)->addData([
                'title' => 'Welcome to the Zoo!',
            ]);

            $routes = new RouteCollection($container);

            $routes->get('/', 'SimpleZoo\Controllers\ZooController::home');
            $routes->get('/advance', 'SimpleZoo\Controllers\ZooController::advance');
            $routes->get('/feed', 'SimpleZoo\Controllers\ZooController::feed');
            $routes->get('/reset', 'SimpleZoo\Controllers\ZooController::reset');

            self::$application = new self($container, $routes);
        }

        return self::$application;
    }

    /**
     *
     */
    public function respond()
    {
        $request = $this->container->get(ServerRequest::class);
        $response = $this->container->get(Response::class);

        try {

            $response = $this->routes->dispatch($request, $response);

        } catch (NotFoundException $e) {
            $response->getBody()->write($e->getMessage());
            $response = $response->withStatus($e->getStatusCode());
        } catch (RuntimeException $runtimeException) {
            $response = $response->withStatus(302);
        }

        $this->container->get(SapiEmitter::class)->emit($response);
    }
} 