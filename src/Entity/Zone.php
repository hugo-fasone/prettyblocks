<?php
declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private string $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $label;

    /**
     * @ORM\OneToMany(targetEntity="Element", mappedBy="zone", cascade={"persist", "remove"})
     */
    private Collection $elements;

    public function __construct(string $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
        $this->elements = new ArrayCollection();
    }

    /**
     * Return the ID of the zone
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Return the label of the zone
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Return the collection of elements in the zone
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    /**
     * Add an element to the zone
     */
    public function addElement(ElementInterface $element): void
    {
        if (false === $this->elements->contains($element)) {
            $this->elements->add($element);
            $element->setZone($this);
        }
    }

    /**
     * Remove an element from the zone
     */
    public function removeElement(ElementInterface $element): void
    {
        if (true === $this->elements->contains($element)) {
            $this->elements->removeElement($element);
            $element->setZone(null);
        }
    }

    /**
     * Remove all elements from the zone
     */
    public function removeAllElements(): void
    {
        foreach ($this->elements as $element) {
            $this->removeElement($element);
        }
    }
}
