<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Block;

use Doctrine\ORM\Mapping as ORM;
use PrestaSafe\PrettyBlocks\Entity\Element;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractBlock extends Element implements BlockInterface
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
     * @ORM\Column(type="json")
     */
    protected $fields = [];

    /**
     * @ORM\Column(type="integer")
     */
    protected int $position;

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

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    abstract public function validate(): bool;
}
