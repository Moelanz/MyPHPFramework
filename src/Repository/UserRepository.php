<?php
namespace App\Repository;

use App\Core\Database\EntityManager;
use App\Core\Database\EntityRepository;
use App\Entity\User;

class UserRepository extends EntityRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }
}