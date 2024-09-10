<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Registry;

use Doctrine\Common\Collections\ArrayCollection;

class ElementRegistry
{
    private ArrayCollection $elementTypes;

    public function __construct()
    {
        $this->elementTypes = new ArrayCollection();
    }

    public function registerElementType(string $type, string $className): void
    {
        if (isset($this->elementTypes[$type])) {
            throw new \InvalidArgumentException(sprintf('Element type "%s" is already registered', $type));
        }
        $this->elementTypes[$type] = $className;
    }

    public function getElementClass(string $type): ?string
    {
        return $this->elementTypes[$type] ?? null;
    }

    public function getRegisteredElements(): ArrayCollection
    {
        return $this->elementTypes;
    }
}
