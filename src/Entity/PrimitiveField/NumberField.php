<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\PrimitiveField;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="number_fields")
 */
class NumberField extends AbstractPrimitiveField
{
    /**
     * @ORM\Column(type="integer")
     */
    protected mixed $value;

    public function validate(): bool
    {
        return is_numeric($this->value);
    }
}
