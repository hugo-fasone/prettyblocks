<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Factory;

use InvalidArgumentException;
use PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface;
use PrestaSafe\PrettyBlocks\Entity\Component\ComponentInterface;
use PrestaSafe\PrettyBlocks\Entity\PrimitiveField\PrimitiveFieldInterface;
use PrestaSafe\PrettyBlocks\Registry\ElementRegistry;

class EntityFactory
{
    private $registry;

    public function __construct(ElementRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function createBlock(array $data): BlockInterface
    {
        $className = $this->registry->getElementClass($data['block_id']);

        if (!$className || !class_exists($className)) {
            throw new InvalidArgumentException("Block type not registered: {$data['block_id']}");
        }

        // Hydrate fields if necessary
        return new $className($data['id'], $data['label']);
    }

    public function createComponent(array $data): ComponentInterface
    {
        $className = $this->registry->getComponentClass($data['type']);

        if (!$className || !class_exists($className)) {
            throw new InvalidArgumentException("Component type not registered: {$data['type']}");
        }

        // Hydrate fields if necessary
        return new $className($data['id'], $data['label'], $data['type']);
    }

    public function createField(array $data): PrimitiveFieldInterface
    {
        $className = $this->registry->getFieldClass($data['type']);

        if (!$className || !class_exists($className)) {
            throw new InvalidArgumentException("Field type not registered: {$data['type']}");
        }

        $field = new $className($data['id'], $data['label']);
        $field->setValue($data['content']['value']);
        return $field;
    }
}
