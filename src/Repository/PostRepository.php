<?php namespace App\Repository;

use Moelanz\Database\EntityManager;
use Moelanz\Database\EntityRepository;
use App\Entity\Post;

/**
 *
 */
class PostRepository extends EntityRepository
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Post::class);
    }
}