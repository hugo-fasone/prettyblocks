<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Repository;

use Doctrine\ORM\EntityRepository;
use PrestaSafe\PrettyBlocks\Entity\ElementInterface;

class BlockRepository extends EntityRepository
{
    public function save(ElementInterface $block): void
    {
        $this->_em->persist($block);
        $this->_em->flush();
    }

    public function findById(string $id): ?ElementInterface
    {
        return $this->find($id);
    }

}
