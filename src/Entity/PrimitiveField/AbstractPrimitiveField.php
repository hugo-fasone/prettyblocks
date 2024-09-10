<?php
declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\PrimitiveField;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractPrimitiveField implements PrimitiveFieldInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected string $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $label;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected mixed $value;

    public function __construct(string $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    abstract public function validate(): bool;
}
