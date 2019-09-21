<?php
namespace App;

use Closure;
use ReflectionClass;
use ReflectionException;

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

        if($alias)
        {
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
        if(!$this->hasService($name))
        {
            return null;
        }

        if($this->services[$name] instanceof Closure)
        {
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

    public function loadServices(string $namespace, ?Closure $callback = null): void
    {
        $baseDir = __DIR__ . '/';

        $actualDirectory = str_replace('\\', '/', $namespace);
        $actualDirectory = $baseDir . substr($actualDirectory, strpos($actualDirectory, '/') +1 );

        $files = array_filter(scandir($actualDirectory), static function ($file)
        {
            return $file !== '.' && $file !== '..';
        });

        foreach ($files as $file)
        {
            try
            {
                $class = new ReflectionClass($namespace . '\\' . basename($file, '.php'));
                $serviceName = $class->getName();

                $constructor = $class->getConstructor();
                if(!$constructor)
                {
                    $this->addService($serviceName, static function() use ($serviceName)
                    {
                        return new $serviceName();
                    });

                    if($callback)
                    {
                        $callback($serviceName, $class);
                    }

                    continue;
                }

                $arguments = $constructor->getParameters();
                if(!$arguments)
                {
                    continue;
                }

                //Parameters to inject into service constructor
                $serviceParameters = [];

                foreach($arguments as $argument)
                {
                    $type = (string)$argument->getType();

                    if ($this->hasService($type) || $this->hasAlias($type))
                    {
                        $serviceParameters[] = $this->getService($type) ?? $this->getAlias($type);
                    }
                    else
                    {
                        $serviceParameters[] = function () use ($type)
                        {
                            return $this->getService($type) ?? $this->getAlias($type);
                        };
                    }
                }

                $this->addService($serviceName, static function() use ($serviceName, $serviceParameters)
                {
                    foreach($serviceParameters as &$serviceParameter)
                    {
                        if($serviceParameter instanceof Closure)
                        {
                            $serviceParameter = $serviceParameter();
                        }
                    }

                    return new $serviceName(...$serviceParameters);
                });

                if($callback)
                {
                    $callback($serviceName, $class);
                }
            }
            catch (ReflectionException $e)
            {
                echo 'No files found in ' . $namespace;
            }

        }
    }
}