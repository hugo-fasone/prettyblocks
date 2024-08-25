<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\PrimitiveField;

interface PrimitiveFieldInterface
{
    public function getId(): string;

    public function getLabel(): string;

    public function getValue();

    public function setValue($value): void;

    public function validate(): bool;
}
