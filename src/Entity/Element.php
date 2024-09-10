<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="elements")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="element_type", type="string")
 * @ORM\DiscriminatorMap({
 *      "block" = "PrestaSafe\PrettyBlocks\Entity\Block\AbstractBlock",
 *      "component" = "PrestaSafe\PrettyBlocks\Entity\Component\AbstractComponent"
 *     })
 */
abstract class Element implements ElementInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected string $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $position;

    /**
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="elements")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", nullable=false)
     */
    protected Zone $zone;

    public function getId(): string
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getZone(): Zone
    {
        return $this->zone;
    }

    public function setZone(Zone $zone): void
    {
        $this->zone = $zone;
    }
}
