<?php namespace App\Repository;

use Moelanz\Database\EntityManager;
use Moelanz\Database\EntityRepository;
use App\Entity\User;

/**
 *
 */
class UserRepository extends EntityRepository
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }
}