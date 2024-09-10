<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Install;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Evolutive\Library\Install\AbstractInstaller;
use Evolutive\Library\Tab\TabCollection;
use Exception;
use Module;
use PrestaSafe\PrettyBlocks\Entity\Block\TextBlock;
use PrestaSafe\PrettyBlocks\Entity\Component\TextComponent;
use PrestaSafe\PrettyBlocks\Entity\PrimitiveField\NumberField;
use PrestaSafe\PrettyBlocks\Entity\PrimitiveField\TextField;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Registry\ElementRegistry;
use PrestaSafe\PrettyBlocks\Service\DynamicDiscriminatorMapService;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Module\ModuleInterface;
use PrestaShopBundle\Translation\TranslatorInterface;

class Installer extends AbstractInstaller
{
    protected ElementRegistry $elementRegistry;
    protected DynamicDiscriminatorMapService $dynamicDiscriminatorMapService;

    public function __construct(TranslatorInterface $translator, Connection $connection, $module)
    {
        parent::__construct($translator, $connection);

        $entityManager = $module->get('doctrine.orm.entity_manager');
        $this->elementRegistry = new ElementRegistry();
        $this->dynamicDiscriminatorMapService = new DynamicDiscriminatorMapService($entityManager, $this->elementRegistry);
    }

    public function getHooks(): array
    {
        return [
            'displayHome',
            'displayFooter',
            'displayLeftColumn',
            'displayRightColumn',
            'displayHeader',
            'actionDispatcher',
            'actionFrontControllerSetVariables',
            'ActionRegisterThemeSettings',
        ];
    }

    /**
     * If you want to add tabs to the back office, you can do it here.
     * Note that if you use a ParentTab, it will create tabs un page, if not, it will create a new sidebar menu.
     *
     * @return TabCollection
     */
    public function getTabs(): TabCollection
    {
        return new TabCollection();
    }

    public function install(Module $module): bool
    {
        $this->registerDoctrineNamespace();
        $this->registerInitialElements();
        $this->dynamicDiscriminatorMapService->updateDiscriminatorMap();
        return $this->installSchema($module) && parent::install($module);
    }

    public function uninstall(Module $module): bool
    {
        return parent::uninstall($module);
    }

    /**
     * Install the schema for Doctrine entities
     */
    protected function installSchema(Module $module): bool
    {
        $entityManager = $this->getEntityManager();

        $tool = new SchemaTool($entityManager);

        try {
            $this->dynamicDiscriminatorMapService->updateDiscriminatorMap();
            $allMetadata = $entityManager->getMetadataFactory()->getAllMetadata();
            $namespace = 'PrestaSafe\PrettyBlocks\Entity';

            $filteredMetadata = array_filter($allMetadata, function ($classMetadata) use ($namespace) {
                return str_contains($classMetadata->getName(), $namespace);
            });

            $tool->createSchema($filteredMetadata);
        } catch (Exception $e) {
            $module->displayError($e->getMessage());
            return false;
        }

        return true;
    }

    protected function registerDoctrineNamespace(): void
    {
        $entityManager = $this->getEntityManager();
        $config = $entityManager->getConfiguration();

        $annotationDriver = new AnnotationDriver(
            new AnnotationReader(),
            [dirname(__DIR__, 2) . '/src/Entity']
        );

        ($config->getMetadataDriverImpl())->addDriver($annotationDriver, 'PrestaSafe\PrettyBlocks\Entity');

    }

    public function getClasses(EntityManager $entityManager): array
    {
        return [
            $entityManager->getClassMetadata(Zone::class),
            $entityManager->getClassMetadata(NumberField::class),
            $entityManager->getClassMetadata(TextField::class),
            $entityManager->getClassMetadata(TextBlock::class),
            $entityManager->getClassMetadata(TextComponent::class),
        ];
    }

    /**
     * Uninstall the schema (drop tables)
     */
    protected function uninstallSchema(Module $module): bool
    {
        $entityManager = $this->getEntityManager();

        $tool = new SchemaTool($entityManager);

        $classes = $this->getClasses($entityManager);

        try {
            $tool->dropSchema($classes);
        } catch (Exception $e) {
            $module->displayError($e->getMessage());
            return false;
        }
        return true;
    }


    public function updateDoctrineSchemaWithNewBlocks(): void
    {
        $entityManager = $this->getEntityManager();
        $schemaTool = new SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->updateSchema($classes, true);
    }

    /**
     * Get the Doctrine Entity Manager
     */
    protected function getEntityManager(): EntityManager
    {
        return (SymfonyContainer::getInstance())->get('doctrine.orm.entity_manager');
    }

    private function registerInitialElements()
    {
        $this->elementRegistry->registerElementType('text', TextBlock::class);
        $this->elementRegistry->registerElementType('text-component', TextComponent::class);
    }
}
