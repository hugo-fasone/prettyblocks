<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Component;

use Doctrine\ORM\Mapping as ORM;
use PrestaSafe\PrettyBlocks\Entity\Element;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractComponent extends Element implements ComponentInterface
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
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $position;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function __construct(string $id, string $label, string $type)
    {
        $this->id = $id;
        $this->label = $label;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    abstract public function validate(): bool;
}
