<?php namespace App;

use Moelanz\Annotations\Route;
use Moelanz\Container;
use Moelanz\Exception\ExceptionService;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Kernel
 * @package App
 *
 * @author Moelanz
 */
class Kernel
{
    private $container;
    private $routes = [];

    /**
     *
     */
    public function __construct()
    {
        $this->container = new Container();
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     *
     */
    public function boot(): void
    {
        $this->loadTwig();
        $this->bootContainer($this->container);
    }

    /**
     * @param Container $container
     * @throws \ReflectionException
     */
    public function bootContainer(Container $container): void
    {
        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();

        $routes = [];

        $container->loadServices('App\\Controller', static function(string $serviceName, ReflectionClass $class) use ($reader, &$routes) {
            $route = $reader->getClassAnnotation($class, Route::class);
            $baseRoute = $route ? $route->route : '';

            foreach ($class->getMethods() as $method) {
                $route = $reader->getMethodAnnotation($method, Route::class);

                if ( ! $route) {
                    continue;
                }

                $routes["@$route->method " . str_replace('//' , '/', $baseRoute . $route->route)] = [
                    'service' => $serviceName,
                    'action' => $method->getName(),
                    'method' => $route->method,
                ];
            }
        });

        $this->routes = $routes;
    }

    /**
     *
     */
    private function loadTwig(): void
    {
        $loader = new FilesystemLoader(__DIR__.'/../templates');
        $twig = new Environment($loader);

        $this->container->addService(Environment::class, static function() use($twig) {return $twig;});
    }

    /**
     * @throws \ReflectionException
     */
    public function handleRequest(): void
    {
        $this->boot();
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = "@$method " . $_SERVER['REQUEST_URI'];
        $uriAnyMethod = str_replace('@' . $method, '@ANY', $uri);

        if (isset($this->routes[$uriAnyMethod])) {
            $uri = $uriAnyMethod;
        }

        if ( ! isset($this->routes[$uri])) {
            echo $this->container->get(ExceptionService::class)->getExceptionController()->httpNotFound($uri);
            return;
        }

        $route = $this->routes[$uri];
        $response = $this->container->getService($route['service'])->{$route['action']}();
        echo $response;
        die();
    }
}
