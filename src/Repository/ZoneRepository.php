<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Repository;

use Doctrine\ORM\EntityRepository;
use PrestaSafe\PrettyBlocks\Entity\Zone;

class ZoneRepository extends EntityRepository
{
    public function save(Zone $zone): void
    {
        $this->_em->persist($zone);
        $this->_em->flush();
    }

    public function findById(string $id): ?Zone
    {
        return $this->find($id);
    }

    public function findAllZones(): array
    {
        return $this->findAll();
    }
}
