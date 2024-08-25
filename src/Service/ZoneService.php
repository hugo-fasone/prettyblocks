<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Service;

use PrestaSafe\PrettyBlocks\Entity\Component\AbstractComponent;
use PrestaSafe\PrettyBlocks\Entity\PrimitiveField\AbstractPrimitiveField;
use PrestaSafe\PrettyBlocks\Entity\PrimitiveField\TextField;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Factory\EntityFactory;
use PrestaSafe\PrettyBlocks\Repository\ZoneRepository;
use PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface;

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
            $block = $this->hydrateBlockFromData($blockData);
            $zone->addBlock($block);
        }

        $this->zoneRepository->save($zone);
    }

    private function hydrateBlockFromData(array $data): BlockInterface
    {
        return $this->entityFactory->createBlock($data);
    }

}
