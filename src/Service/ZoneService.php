<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Service;

use PrestaSafe\PrettyBlocks\Entity\ElementInterface;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Factory\EntityFactory;
use PrestaSafe\PrettyBlocks\Repository\ZoneRepository;

class ZoneService
{
    private $zoneRepository;
    private $entityFactory;

    public function __construct(ZoneRepository $zoneRepository, EntityFactory $entityFactory)
    {
        $this->zoneRepository = $zoneRepository;
        $this->entityFactory = $entityFactory;
    }

    /**
     * Récupère toutes les zones disponibles
     */
    public function getAllZones(): array
    {
        return $this->zoneRepository->findAllZones();  // Utilise la méthode findAllZones du repository
    }

    public function updateZone(Zone $zone, array $elements): void
    {
        // Retirer les anciens éléments de la zone
        $zone->removeAllElements();

        // Ajouter les nouveaux éléments avec position
        foreach ($elements as $elementData) {
            $element = $this->hydrateElementFromData($elementData);
            $zone->addElement($element);
        }

        // Sauvegarder la zone avec les éléments mis à jour
        $this->zoneRepository->save($zone);
    }

    /**
     * Récupère une zone spécifique par son ID
     */
    public function getZoneById(string $id): ?Zone
    {
        return $this->zoneRepository->findById($id);  // Utilise la méthode findById du repository
    }

    private function hydrateElementFromData(array $data): ElementInterface
    {
        $element = $this->entityFactory->createBlock($data); // Si c'est un bloc
        if ($data['type'] === 'component') {
            $element = $this->entityFactory->createComponent($data);
        }

        // Hydrater la position de l'élément
        $element->setPosition($data['position']);

        return $element;
    }
}
