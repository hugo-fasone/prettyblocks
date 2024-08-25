<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Component;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PrestaSafe\PrettyBlocks\Repository\ComponentRepository")
 * @ORM\Table(name="text_components")
 */
class TextComponent extends AbstractComponent
{
    public function validate(): bool
    {
        // Validation spécifique pour le TextComponent
        return true;
    }
}
