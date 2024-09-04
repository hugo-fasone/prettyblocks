<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use PrestaSafe\PrettyBlocks\Registry\EntityRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlockController extends AbstractController
{
    protected EntityRegistry $entityRegistry;

    public function __construct(EntityRegistry $entityRegistry)
    {
        $this->entityRegistry = $entityRegistry;
    }

    /**
     * Endpoint to list all available blocks
     */
    public function listBlocks(): JsonResponse
    {
        $this->entityRegistry->getAvailableBlockTypes();
    }

}
