<?php
/**
 * Copyright (c) Since 2020 PrestaSafe and contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@prestasafe.com so we can send you a copy immediately.
 *
 * @author    PrestaSafe <contact@prestasafe.com>
 * @copyright Since 2020 PrestaSafe and contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaSafe
 */

use PrestaSafe\PrettyBlocks\Install\Installer;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class PrettyBlocks extends Module implements WidgetInterface
{
    public $js_path;
    public $css_path;
    public $tabs = [
        [
            'name' => 'Pretty Blocks', // One name for all langs
            'class_name' => 'AdminThemeManagerController',
            'visible' => true,
            'parent_class_name' => 'IMPROVE',
        ],
    ];

    public function __construct()
    {
        $this->name = 'prettyblocks';
        $this->tab = 'administration';
        $this->version = '4.0.0';
        $this->author = 'PrestaSafe';
        $this->need_instance = 1;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Pretty Blocks', [], 'Modules.Prettyblocks.Admin');
        $this->description = $this->trans('Configure your design easily', [], 'Modules.Prettyblocks.Admin');
        $this->controllers = ['ajax'];

        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function getContent()
    {
        $domain = Tools::getShopDomainSsl(true);
        $symfonyUrl = $domain . Link::getUrlSmarty([
                'entity' => 'sf',
                'route' => 'admin_prettyblocks',
            ]);

        return Tools::redirect($symfonyUrl);
    }

    private function loadDefault()
    {
        return Configuration::updateGlobalValue('_PRETTYBLOCKS_TOKEN_', Tools::passwdGen(25));
    }

    public function install(): bool
    {
        if (!(parent::install())) {
            return false;
        }

        /** @var \Doctrine\DBAL\Connection $dbalConnection */
        $dbalConnection = $this->get('doctrine.dbal.default_connection');

        /** @var Installer $installer */
        $installer = (new Installer($this->getTranslator(), $dbalConnection));

        try {
            return $installer->install($this);
        } catch (Exception $e) {
            $this->displayError($e->getMessage());
            $installer->uninstall($this);
            parent::uninstall();

            return false;
        }
    }

    /**
     * @return bool
     *
     * @throws Exception
     */
    public function uninstall(): bool
    {
        /** @var \Doctrine\DBAL\Connection $dbalConnection */
        $dbalConnection = $this->get('doctrine.dbal.default_connection');

        /** @var Installer $installer */
        $installer = (new Installer($this->getTranslator(), $dbalConnection));

        try {
            return ($installer)->uninstall($this) && parent::uninstall();
        } catch (Exception $e) {
            $this->displayError($e->getMessage());

            return false;
        }
    }

    public function hookActionFrontControllerSetVariables()
    {
        return [
            // 'ajax_builder_url' => $this->context->link->getModuleLink($this->name,'ajax'),
            'theme_settings' => PrettyBlocksModel::getThemeSettings(false, 'front'),
            'id_shop' => (int) $this->context->shop->id,
            'shop_name' => $this->context->shop->name,
            'shop_current_url' => $this->context->shop->getBaseURL(true, true),
        ];
    }

    /**
     * Generate $state to block view
     *
     * @return array
     */
    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $block = (isset($configuration['block'])) ? PrettyBlocksModel::loadBlock($configuration['block']) : [];

        return [
            'block' => $block,
            'hookName' => $hookName,
            'configuration' => $configuration,
        ];
    }

    public function hookdisplayHeader($params)
    {
        if ((isset($_SERVER['HTTP_SEC_FETCH_DEST']) && $_SERVER['HTTP_SEC_FETCH_DEST'] == 'iframe') || Tools::getValue('prettyblocks') === '1') {
            $this->context->controller->registerJavascript(
                'prettyblocks',
                'modules/' . $this->name . '/views/js/build.js',
                [
                    'position' => 'bottom',
                    'priority' => 150,
                ]
            );
            $this->context->controller->registerStylesheet(
                'prettyblocks',
                'modules/' . $this->name . '/build/iframe.css',
                [
                    'media' => 'all',
                    'priority' => 200,
                ]
            );
            $this->context->smarty->assign([
                'prettyblocks' => true,
            ]);
            // todo register css and js on iframe only from Hook
        }
    }

    /**
     * Return la view
     */
    public function renderWidget($hookName = null, array $configuration = [])
    {
        $vars = $this->getWidgetVariables($hookName, $configuration);
        $this->smarty->assign($vars);
        if (isset($configuration['zone_name'])) {
            return $this->renderZone(['zone_name' => pSQL($configuration['zone_name'])]);
        }
        if (isset($configuration['action']) && $configuration['action'] == 'GetBlockRender') {
            $block = $configuration['data'];
            $vars = [
                'id_prettyblocks' => $block['id_prettyblocks'],
                'instance_id' => $block['instance_id'],
                'state' => $block['repeater_db'],
                'block' => $block,
                'test' => Hook::exec('beforeRenderingBlock', ['state' => $configuration['data']], null, true),
            ];
            $this->smarty->assign($vars);
            $template = $block['templates'][$block['templateSelected']] ?? 'module:prettyblocks/views/templates/blocks/welcome.tpl';

            return $this->fetch($template);
        }
        if ($vars['hookName'] !== null) {
            return $this->renderZone(['zone_name' => $vars['hookName']]);
        }
    }

    public function registerBlockToZone($zone_name, $block_code)
    {
        return PrettyBlocksModel::registerBlockToZone($zone_name, $block_code);
    }

    /**
     * Hook dispatcher for registering smarty function
     */
    public function hookActionDispatcher()
    {
        /* @deprecated {magic_zone} is deprecated since v1.1.0. Use {prettyblocks_zone} instead. */
        $this->context->smarty->registerPlugin('function', 'magic_zone', [PrettyBlocks::class, 'renderZone']);
        $this->context->smarty->registerPlugin('function', 'prettyblocks_zone', [PrettyBlocks::class, 'renderZone']);
        $this->context->smarty->registerPlugin('function', 'prettyblocks_title', [PrettyBlocks::class, 'renderTitle']);
    }
}
