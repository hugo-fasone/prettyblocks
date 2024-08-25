<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Registry;

class EntityRegistry
{
    private array $blockTypes = [];
    private array $componentTypes = [];
    private array $fieldTypes = [];

    public function registerBlockType(string $type, string $className): void
    {
        $this->blockTypes[$type] = $className;
    }

    public function registerComponentType(string $type, string $className): void
    {
        $this->componentTypes[$type] = $className;
    }

    public function registerFieldType(string $type, string $className): void
    {
        $this->fieldTypes[$type] = $className;
    }

    public function getBlockClass(string $type): ?string
    {
        return $this->blockTypes[$type] ?? null;
    }

    public function getComponentClass(string $type): ?string
    {
        return $this->componentTypes[$type] ?? null;
    }

    public function getFieldClass(string $type): ?string
    {
        return $this->fieldTypes[$type] ?? null;
    }
}
