<?php namespace Moelanz\Database;

/**
 * Class Property
 * @package Moelanz\Database
 *
 * @author Moelanz
 */
class Property
{
    /**
     * Database Name
     *
     * @var string|null
     */
    private ? string $databaseName = null;

    /**
     * Entity Property
     *
     * @var string|null
     */
    private ? string $property = null;

    /**
     * Entity Getter
     *
     * @var string|null
     */
    private ? string $getter = null;

    /**
     * Property Database Type
     *
     * @var string|null
     */
    private ? string $type = null;

    /**
     * Property Database Length
     *
     * @var int|null
     */
    private ? int $length = null;

    /**
     * Nullable
     *
     * @var bool|null
     */
    private ? bool $nullable = null;

    /**
     * Set Database Name
     *
     * @param string|null $databaseName
     * @return $this
     */
    public function setDatabaseName(?string $databaseName): self
    {
        $this->databaseName = $databaseName;
        return $this;
    }

    /**
     * Get Database Name
     *
     * @return string|null
     */
    public function getDatabaseName(): ?string
    {
        return $this->databaseName;
    }

    /**
     * Set Property
     *
     * @param string|null $property
     * @return $this
     */
    public function setProperty(?string $property): self
    {
        $this->property = $property;
        return $this;
    }

    /**
     * Get Property
     *
     * @return string|null
     */
    public function getProperty(): ?string
    {
        return $this->property;
    }

    /**
     * Set Getter
     *
     * @param string|null $getter
     * @return $this
     */
    public function setGetter(?string $getter): self
    {
        $this->getter = $getter;
        return $this;
    }

    /**
     * Get Setter
     *
     * @return string|null
     */
    public function getGetter(): ?string
    {
        return $this->getter;
    }

    /**
     * Set Type
     *
     * @param string|null $type
     * @return $this
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get Type
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set Length
     *
     * @param int|null $length
     * @return $this
     */
    public function setLength(?int $length): self
    {
        $this->length = $length;
        return $this;
    }

    /**
     * Get Length
     *
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * Set Nullable
     *
     * @param bool|null $nullable
     * @return $this
     */
    public function setNullable(?bool $nullable): self
    {
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * Get Nullable
     *
     * @return bool|null
     */
    public function getNullable(): ?bool
    {
        return $this->nullable;
    }
}