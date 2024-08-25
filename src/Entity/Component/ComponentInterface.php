<?php

namespace PrestaSafe\PrettyBlocks\Entity\Component;

interface ComponentInterface
{
    public function getId(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function validate(): bool;
}
