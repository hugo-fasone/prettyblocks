<?php
declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\PrimitiveField;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="text_fields")
 */
class TextField extends AbstractPrimitiveField
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected mixed $value;

    public function validate(): bool
    {
        return is_string($this->value);
    }
}
