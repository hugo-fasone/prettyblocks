<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Repository;

use Doctrine\ORM\EntityRepository;
use PrestaSafe\PrettyBlocks\Entity\Component\ComponentInterface;

class ComponentRepository extends EntityRepository
{
    public function save(ComponentInterface $component): void
    {
        $this->_em->persist($component);
        $this->_em->flush();
    }

    public function findById(string $id): ?ComponentInterface
    {
        return $this->find($id);
    }

}
