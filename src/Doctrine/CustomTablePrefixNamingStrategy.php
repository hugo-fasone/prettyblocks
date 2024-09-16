<?php
declare(strict_types=1);

namespace Evolutive\Library\Doctrine;

use Doctrine\ORM\Mapping\DefaultNamingStrategy;

class CustomTablePrefixNamingStrategy extends DefaultNamingStrategy
{
    private string $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Applique le préfixe à toutes les tables
     */
    public function classToTableName($className): string
    {
        return $this->prefix . parent::classToTableName($className);
    }

    /**
     * Applique le préfixe aux tables des associations (join tables)
     */
    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null): string
    {
        return $this->prefix . parent::joinTableName($sourceEntity, $targetEntity, $propertyName);
    }

}
