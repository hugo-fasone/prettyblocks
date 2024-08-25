<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Block;

interface BlockInterface
{
    public function getId(): string;

    public function getLabel(): string;

    public function getFields(): array;

    public function addField($field): void;

    public function validate(): bool;
}
