<?php
declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

interface ElementInterface
{
    public function getId(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function getPosition(): int;

    public function setPosition(int $position): void;
}
