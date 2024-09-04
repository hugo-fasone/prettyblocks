<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use PrestaSafe\PrettyBlocks\Service\ZoneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ZoneController extends AbstractController
{
    private $zoneService;

    public function __construct(ZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
    }

    /**
     * Endpoint to list all available zones
     */
    public function listZones(): JsonResponse
    {
        $zones = $this->zoneService->getAllZones();
        $data = [];

        foreach ($zones as $zone) {
            $data[] = [
                'id' => $zone->getId(),
                'label' => $zone->getLabel(),
                // You can add more details if needed
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Endpoint to get a specific zone by ID
     */
    public function getZone(string $id): JsonResponse
    {
        $zone = $this->zoneService->getZoneById($id);

        if (!$zone) {
            return new JsonResponse(['error' => 'Zone not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $zone->getId(),
            'label' => $zone->getLabel(),
            'blocks' => [],
        ];

        foreach ($zone->getBlocks() as $block) {
            $data['blocks'][] = [
                'id' => $block->getId(),
                'label' => $block->getLabel(),
                'fields' => $block->getFields(),
                // Include more block details if necessary
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Endpoint to update a specific zone by ID with edited blocks
     */
    public function updateZone(Request $request, string $id): JsonResponse
    {
        $zone = $this->zoneService->getZoneById($id);

        if (!$zone) {
            return new JsonResponse(['error' => 'Zone not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (!isset($data['blocks'])) {
            return new JsonResponse(['error' => 'Invalid data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->zoneService->updateZone($zone, $data['blocks']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['status' => 'Zone updated successfully']);
    }

}
