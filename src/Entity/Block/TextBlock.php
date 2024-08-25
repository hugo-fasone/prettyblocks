<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Block;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PrestaSafe\PrettyBlocks\Repository\BlockRepository")
 * @ORM\Table(name="text_blocks")
 */
class TextBlock extends AbstractBlock
{
    public function validate(): bool
    {
        // Validation spécifique pour le TextBlock
        return true;
    }
}
