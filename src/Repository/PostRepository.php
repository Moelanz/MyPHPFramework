<?php
namespace App\Repository;

use App\Core\Database\EntityManager;
use App\Core\Database\EntityRepository;
use App\Entity\Post;

class PostRepository extends EntityRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Post::class);
    }
}