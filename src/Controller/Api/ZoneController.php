<?php
declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use Exception;
use JsonException;
use PrestaSafe\PrettyBlocks\Service\ZoneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ZoneController extends AbstractController
{
    private ZoneService $zoneService;

    public function __construct(ZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
    }

    /**
     * Return the list of all available zones
     */
    public function listZones(): JsonResponse
    {
        $zones = $this->zoneService->getAllZones();
        $data = [];

        foreach ($zones as $zone) {
            $data[] = [
                'id' => $zone->getId(),
                'label' => $zone->getLabel(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Return a specific zone by its ID
     */
    public function getZone(string $id): JsonResponse
    {
        $zone = $this->zoneService->getZoneById($id);

        if (null === $zone) {
            return new JsonResponse(['error' => 'Zone not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $zone->getId(),
            'label' => $zone->getLabel(),
            'elements' => []
        ];

        foreach ($zone->getElements() as $element) {
            $data['elements'][] = [
                'id' => $element->getId(),
                'label' => $element->getLabel(),
                'type' => $element->getType(),
                'position' => $element->getPosition(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Update a specific zone by its ID with edited elements
     * @throws JsonException
     */
    public function updateZone(Request $request, string $id): JsonResponse
    {
        $zone = $this->zoneService->getZoneById($id);

        if (null === $zone) {
            return new JsonResponse(['error' => 'Zone not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (false === isset($data['elements'])) {
            return new JsonResponse(['error' => 'Invalid data format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $this->zoneService->updateZone($zone, $data['elements']);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['status' => 'Zone updated successfully']);
    }
}
