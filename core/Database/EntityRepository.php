<?php namespace Moelanz\Database;

use Moelanz\Annotations\Column;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use LogicException;
use ReflectionClass;
use ReflectionException;

/**
 * Class EntityRepository
 * @package Moelanz\Database
 *
 * @author Moelanz
 */
class EntityRepository
{
    private const PROPERTY_NAME = 'PROPERTY_NAME';
    private const PROPERTY_PARAM = 'PROPERTY_PARAM';
    private const PROPERTY_UPDATE = 'PROPERTY_UPDATE';

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var array|string|string[]
     */
    private $entityName;

    /**
     * @param EntityManager $entityManager
     * @param string $entityClass
     */
    public function __construct(EntityManager $entityManager, string $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
        $this->entityName = str_replace(dirname($entityClass) . "\\", '', $entityClass);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $sql = /** @lang text */
            'SELECT * FROM ' . $this->entityName . ' WHERE id = :id';

        $this->entityManager->query( $sql);
        $this->entityManager->bindParam(':id', $id);
        return $this->entityManager->getSingleResult($this->entityClass);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        // Create sql query
        $sql = /** @lang text */
            'SELECT * FROM ' . $this->entityName;

        $this->entityManager->query($sql);
        return $this->entityManager->getSingleResult($this->entityClass);
    }

    /**
     * @param $entity
     * @return bool
     * @throws AnnotationException
     */
    public function save($entity): bool
    {
        // If the ID is set, we're updating an existing record
        if ($entity->getId() !== null) {
            return $this->update($entity);
        }

        // Create sql query
        $sql = /** @lang text */
            'INSERT INTO ' . $this->entityName . '(';
        $sql .= $this->createPropertiesSql($this->getClassProperties(), self::PROPERTY_NAME);
        $sql .= ') VALUES (';
        $sql .= $this->createPropertiesSql($this->getClassProperties(), self::PROPERTY_PARAM);
        $sql .= ')';

        $this->entityManager->query($sql);

        foreach ($this->getClassProperties() as $property) {
            $getter = 'get' . ucwords($property);
            $this->entityManager->bindParam(':' . $property, $entity->$getter());
        }

        return $this->entityManager->execute();
    }

    /**
     * @param $entity
     * @return bool
     * @throws AnnotationException
     */
    public function update($entity): bool
    {
        if ($entity->getId() === null) {
            // We can't update a record unless it exists...
            throw new LogicException(
                'Cannot update ' . $this->entityName . ' that does not yet exist in the database.'
            );
        }

        // Create sql query
        $sql = /** @lang text */
            'UPDATE ' . $this->entityName . ' SET ';
        $sql .= $this->createPropertiesSql($this->getClassProperties(), self::PROPERTY_UPDATE);
        $sql .= ' WHERE id = :id';

        $this->entityManager->query($sql);

        $this->entityManager->bindParam(':id', $entity->getId());
        foreach ($this->getClassProperties() as $property) {
            $getter = 'get' . ucwords($property);
            $this->entityManager->bindParam(':' . $property, $entity->$getter());
        }

        return $this->entityManager->execute();
    }

    /**
     * @return array
     * @throws AnnotationException
     */
    private function getClassProperties(): array
    {
        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();
        $properties = [];

        try {
            $reflectionClass = new ReflectionClass($this->entityClass);
        }
        catch (ReflectionException $e) {
            die('Class ' . $this->entityClass . ' not found!');
        }

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyHasAnnotation = $reader->getPropertyAnnotation($property, Column::class);

            if ( ! $propertyHasAnnotation) {
                continue;
            }

            $properties[] = $property->name;
        }

        return $properties;
    }

    /**
     * Generate all properties that have a Column annotation
     *
     * @param $properties
     * @param $type
     * @return string
     */
    private function createPropertiesSql($properties, $type): string
    {
        $sql = '';

        foreach ($properties as $key => $property) {

            switch($type) {
                default:
                case self::PROPERTY_NAME:
                    $sql .= $property;
                    break;

                case self::PROPERTY_PARAM:
                    $sql .= ':' . $property;
                    break;

                case self::PROPERTY_UPDATE:
                    $sql .= $property . ' = :' . $property;
                    break;
            }

            // Check for last key, to not add a ,
            if ($key !== array_key_last($properties)) {
                $sql .= ', ';
            }
        }

        return $sql;
    }
}
