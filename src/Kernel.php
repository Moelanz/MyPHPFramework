<?php
namespace App;

use App\Annotations\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;
use App\Service\Serializer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Kernel
{
    private $container;
    private $routes = [];

    public function __construct()
    {
        $this->container = new Container();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function boot(): void
    {
        $this->bootContainer($this->container);
        $this->loadTwig();
    }

    public function bootContainer(Container $container): void
    {
        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();

        $routes = [];

        $container->loadServices('App\\Service');
        $container->loadServices('App\\Controller', static function(string $serviceName, ReflectionClass $class) use ($reader, &$routes)
        {
            $route = $reader->getClassAnnotation($class, Route::class);

            if(!$route)
            {
                return;
            }

            $baseRoute = $route->route;

            foreach ($class->getMethods() as $method)
            {
                $route = $reader->getMethodAnnotation($method, Route::class);

                if(!$route)
                {
                    continue;
                }

                $routes[str_replace('//' , '/', $baseRoute . $route->route)] = [
                    'service' => $serviceName,
                    'method' => $method->getName(),
                ];
            }
        });

        $this->routes = $routes;
    }

    private function loadTwig()
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader, [
            'cache' => 'var/cache',
        ]);

        $this->container->addService(Environment::class, static function() use($twig) {return $twig;});
    }

    public function handleRequest(): void
    {
        $this->boot();
        $uri = $_SERVER['REQUEST_URI'];

        if(!isset($this->routes[$uri]))
        {
            echo $this->container->getAlias('app.service.exceptionservice')->getExceptionController()->httpNotFound($uri);
            return;
        }

        $route = $this->routes[$uri];
        $response = $this->container->getService($route['service'])->{$route['method']}();
        echo $response;
        die();
    }
}