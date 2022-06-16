<?php namespace Moelanz;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

/**
 * Class Container
 * @package Moelanz
 *
 * @author Moelanz
 */
class Container
{
    private $services = [];
    private $aliases = [];

    /**
     * @param string $name
     * @param Closure $closure
     * @param string $alias
     */
    public function addService(string $name, Closure $closure, ?string $alias = null): void
    {
        $this->services[$name] = $closure;

        if ($alias) {
            $this->addAlias($alias, $name);
            return;
        }

        $this->addAlias(str_replace('\\', '.', strtolower($name)), $name);
    }

    /**
     * @param string $alias
     * @param string $service
     */
    public function addAlias(string $alias, string $service): void
    {
        $this->aliases[$alias] = $service;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasService(string $name): bool
    {
        return isset($this->services[$name]);
    }

    /**
     * @param string $alias
     * @return bool
     */
    public function hasAlias(string $alias): bool
    {
        return isset($this->aliases[$alias]);
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getService(string $name)
    {
        if ( ! $this->hasService($name)) {
            return null;
        }

        if ($this->services[$name] instanceof Closure) {
            $this->services[$name] = $this->services[$name]();
        }

        return $this->services[$name];
    }

    /**
     * @param string $alias
     * @return mixed|null
     */
    public function getAlias(string $alias)
    {
        return $this->getService($this->aliases[$alias]);
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return [
            'services' => array_keys($this->services),
            'aliases' => $this->aliases,
        ];
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @param string $namespace
     * @param Closure|null $callback
     * @throws ReflectionException
     */
    public function loadServices(string $namespace, ?Closure $callback = null): void
    {
        $baseDir = dirname(__DIR__) . '/src/';

        $actualDirectory = str_replace('\\', '/', $namespace);
        $actualDirectory = $baseDir . substr($actualDirectory, strpos($actualDirectory, '/') +1 );

        $files = array_filter(scandir($actualDirectory), static function ($file) {
            return $file !== '.' && $file !== '..';
        });

        foreach ($files as $file) {
            $serviceName = $namespace . '\\' . basename($file, '.php');
            $this->get($serviceName);

            if($callback) {
                $callback($serviceName, new ReflectionClass($serviceName));
            }

        }
    }

    /**
     * @param string $name
     * @return mixed|object|void|null
     * @throws ReflectionException
     */
    public function get(string $name)
    {
        // If we have a binding for it, then it's a closure.
        // We can just invoke it and return the resolved instance.
        if ($this->hasService($name)) {
            return $this->getService($name);
        }

        // Otherwise we are going to try and use reflection to "autowire"
        // the dependencies and instantiate this entry if it's a class.
        if ( ! class_exists($name) && !interface_exists($name)) {
            echo "Service $name does not exist!";
            return;
        }

        $reflector = new ReflectionClass($name);

        if ( ! $reflector->isInstantiable()) {
            echo "Service $name is not instantiable!";
            return;
        }

        /**
         * @var ReflectionMethod | null
         */
        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            $this->addService($name, static function() use ($name) {
                return new $name();
            });

            return new $name();
        }

        $dependencies = array_map(
            function (ReflectionParameter $dependency) use ($name) {

                if ($dependency->getClass() === null) {
                    echo "Service $name could not find class!";
                    return;
                }

                return $this->get($dependency->getClass()->getName());

            },
            $constructor->getParameters()
        );

        $this->addService($name, static function() use ($name, $dependencies) {
            foreach($dependencies as &$serviceParameter) {
                if($serviceParameter instanceof Closure) {
                    $serviceParameter = $serviceParameter();
                }
            }

            return new $name(...$dependencies);
        });

        return $reflector->newInstanceArgs($dependencies);
    }
}
