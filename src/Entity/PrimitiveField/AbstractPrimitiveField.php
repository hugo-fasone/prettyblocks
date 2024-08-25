<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\PrimitiveField;

abstract class AbstractPrimitiveField implements PrimitiveFieldInterface
{
    protected string $id;
    protected string $label;
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
