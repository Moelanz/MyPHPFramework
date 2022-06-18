<?php namespace Moelanz\Annotations;

/**
 * Class Column
 * @package Moelanz\Annotations
 *
 * @author Moelanz
 *
 * @Annotation
 */
class Column
{
    /**
     * Database type
     *
     * @var string
     */
    public $type;

    /**
     * Database length
     *
     * @var int
     */
    public $length;

    /**
     * Database nullable
     *
     * @var bool
     */
    public $nullable;
}