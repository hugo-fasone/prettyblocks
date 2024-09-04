<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Service;

use PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Factory\EntityFactory;
use PrestaSafe\PrettyBlocks\Repository\ZoneRepository;

class ZoneService
{
    private ZoneRepository $zoneRepository;
    private EntityFactory $entityFactory;

    public function __construct(ZoneRepository $zoneRepository, EntityFactory $entityFactory)
    {
        $this->zoneRepository = $zoneRepository;
        $this->entityFactory = $entityFactory;
    }

    public function getAllZones(): array
    {
        return $this->zoneRepository->findAllZones();
    }

    public function getZoneById(string $id): ?Zone
    {
        return $this->zoneRepository->findById($id);
    }

    public function updateZone(Zone $zone, array $blocks): void
    {
        // Remove existing blocks
        foreach ($zone->getBlocks() as $block) {
            $zone->removeBlock($block);
        }

        // Add new blocks
        foreach ($blocks as $blockData) {
            $block = $this->hydrateBlockFromDataStructure($blockData);
            $zone->addBlock($block);
        }

        $this->zoneRepository->save($zone);
    }

    private function hydrateBlockFromDataStructure(array $data): BlockInterface
    {
        $block = $this->entityFactory->createBlock($data);
        // Hydrater les champs du bloc
        foreach ($data['fields'] as $fieldData) {
            $field = $this->entityFactory->createField($fieldData);
            $block->addField($field);
        }

        return $block;
    }
}
