<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Repository;

use Doctrine\ORM\EntityRepository;
use PrestaSafe\PrettyBlocks\Entity\PrimitiveField\PrimitiveFieldInterface;

class PrimitiveFieldRepository extends EntityRepository
{
    public function save(PrimitiveFieldInterface $field): void
    {
        $this->_em->persist($field);
        $this->_em->flush();
    }

    public function findById(string $id): ?PrimitiveFieldInterface
    {
        return $this->find($id);
    }

}
