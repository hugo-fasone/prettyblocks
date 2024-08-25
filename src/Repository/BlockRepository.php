<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Repository;

use Doctrine\ORM\EntityRepository;
use PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface;

class BlockRepository extends EntityRepository
{
    public function save(BlockInterface $block): void
    {
        $this->_em->persist($block);
        $this->_em->flush();
    }

    public function findById(string $id): ?BlockInterface
    {
        return $this->find($id);
    }

}
