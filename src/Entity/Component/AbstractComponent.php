<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity\Component;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractComponent implements ComponentInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $label;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    public function __construct(string $id, string $label, string $type)
    {
        $this->id = $id;
        $this->label = $label;
        $this->type = $type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    abstract public function validate(): bool;
}
