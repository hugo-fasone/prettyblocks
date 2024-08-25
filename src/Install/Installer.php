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

use Evolutive\Library\Install\AbstractInstaller;
use Evolutive\Library\Tab\TabCollection;

class Installer extends AbstractInstaller
{
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
}
