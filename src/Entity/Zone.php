<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

namespace PrestaSafe\PrettyBlocks\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface;

/**
 * @ORM\Entity(repositoryClass="PrestaSafe\PrettyBlocks\Repository\ZoneRepository")
 * @ORM\Table(name="zones")
 */
class Zone
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface", mappedBy="zone", cascade={"persist", "remove"})
     */
    private $blocks;

    public function __construct(string $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
        $this->blocks = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(BlockInterface $block): void
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks[] = $block;
            $block->setZone($this);
        }
    }

    public function removeBlock(BlockInterface $block): void
    {
        if ($this->blocks->contains($block)) {
            $this->blocks->removeElement($block);
            // set the owning side to null
            $block->setZone(null);
        }
    }
}
