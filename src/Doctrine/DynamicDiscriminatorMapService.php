<?php
declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use PrestaSafe\PrettyBlocks\Entity\Element;
use PrestaSafe\PrettyBlocks\Registry\ElementRegistry;

class DynamicDiscriminatorMapService
{
    private EntityManagerInterface $entityManager;
    private ElementRegistry $entityRegistry;

    public function __construct(EntityManagerInterface $entityManager, ElementRegistry $blockRegistry)
    {
        $this->entityManager = $entityManager;
        $this->entityRegistry = $blockRegistry;
    }

    public function updateDiscriminatorMap(): void
    {
        $classMetadata = $this->entityManager->getClassMetadata(Element::class);

        $registeredBlocks = $this->entityRegistry->getRegisteredElements();

        foreach ($registeredBlocks as $elementName => $elementClass) {
            if (!isset($classMetadata->discriminatorMap[$elementName])) {
                $classMetadata->discriminatorMap[$elementName] = $elementClass;
            }
        }
    }
}
