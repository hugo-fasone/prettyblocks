<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Component;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="text_components")
 */
class TextComponent extends AbstractComponent
{
    protected string $type = 'text-component';

    public function validate(): bool
    {
        // Validation spécifique pour le TextComponent
        return true;
    }
}
