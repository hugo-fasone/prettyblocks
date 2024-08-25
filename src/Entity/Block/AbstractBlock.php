<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Block;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractBlock implements BlockInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $label;

    /**
     * @ORM\Column(type="json")
     */
    protected $fields = [];

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

    public function getFields(): array
    {
        return $this->fields;
    }

    public function addField($field): void
    {
        $this->fields[] = $field;
    }

    abstract public function validate(): bool;
}
