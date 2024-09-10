<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Admin;

use Configuration;
use Exception;
use Link;
use Module;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Tools;

class EditionController extends FrameworkBundleAdminController
{
    public function indexAction(): Response
    {
        /** @var LegacyContext $context */
        $context = $this->get('prestashop.adapter.legacy.context');

        [$css, $js, $js_entry] = $this->getAssets($context);

        $module = Module::getInstanceByName('prettyblocks');

        $link = new Link();
        $symfonyUrl = 'https://raviday_core.app.localhost/';
        //$symfonyUrl = $this->get('router')->generate("prettyblocks_zone_get");

        $shop_url = $context->getRootUrl();

        $available_language_ids = $context->getAvailableLanguages();

        return $this->render('@Modules/prettyblocks/templates/admin/index.html.twig', [
            'base_url' => $link->getBaseLink(),
            'favicon_url' => Tools::getShopDomainSsl(true) . '/modules/' . $module->name . '/views/images/favicon.ico',
            'module_name' => $module->displayName,
            'shop_name' => $context->getContext()->shop->name,
            'env' => [
                'vitedev' => filter_var(getenv('PRETTYBLOCKS_VITE_DEV'), FILTER_VALIDATE_BOOLEAN) ?? false,
                'PRETTYBLOCKS_VITE_HOST' => getenv('PRETTYBLOCKS_VITE_HOST') ? getenv('PRETTYBLOCKS_VITE_HOST') : 'http://localhost:3002/',
                'iframe_sandbox' => getenv('PRETTYBLOCKS_IFRAME_SANDBOX') ? getenv('PRETTYBLOCKS_IFRAME_SANDBOX') : 'allow-same-origin allow-scripts allow-forms allow-popups allow-presentation allow-top-navigation allow-pointer-lock allow-popups-to-escape-sandbox allow-modals allow-top-navigation-by-user-activation',
            ],
            'ajax_urls' => [
                'simulate_home' => $symfonyUrl,
                'search_by_ref' => $symfonyUrl,
                'adminURL' => $context->getAdminBaseUrl(),
                // 'update_ajax' => $updateAjax,
                'sf' => $symfonyUrl,
                'api' => $symfonyUrl,
                'current_domain' => $shop_url,
                'block_url' => $symfonyUrl,
                'state' => $symfonyUrl,
                'upload' => $symfonyUrl,
                'collection' => $symfonyUrl,
                //                'blocks_available' => $blockAvailableUrls,
                //                'block_action_urls' => $blockUrl,
                //                'theme_settings' => $settingsUrls,
                'startup_url' => $symfonyUrl,
            ],
            'trans_app' => [
                'current_shop' => $this->trans('Shop in modification', 'Modules.Prettyblocks.Admin'),
                'save' => $this->trans('Save', 'Modules.Prettyblocks.Admin'),
                'add_new_element' => $this->trans('Add new element', 'Modules.Prettyblocks.Admin'),
                'avalaible_elements' => $this->trans('Availables blocks', 'Modules.Prettyblocks.Admin'),
                'close' => $this->trans('Close', 'Modules.Prettyblocks.Admin'),
                'current_zone' => $this->trans('Current zone', 'Modules.Prettyblocks.Admin'),
                'loading' => $this->trans('Loading', 'Modules.Prettyblocks.Admin'),
                'default_settings' => $this->trans('Default settings', 'Modules.Prettyblocks.Admin'),
                'choose_template' => $this->trans('Choose a template', 'Modules.Prettyblocks.Admin'),
                'use_container' => $this->trans('Place the element in a column (container)', 'Modules.Prettyblocks.Admin'),
                'bg_color' => $this->trans('Background color', 'Modules.Prettyblocks.Admin'),
                'ex_color' => $this->trans('Add a color ex: #123456', 'Modules.Prettyblocks.Admin'),
                'theme_settings' => $this->trans('Theme settings', 'Modules.Prettyblocks.Admin'),
                'type_search_here' => $this->trans('Type your search here', 'Modules.Prettyblocks.Admin'),
                'search_blocks' => $this->trans('Search blocks', 'Modules.Prettyblocks.Admin'),
                'is_cached' => $this->trans('Enable cache', 'Modules.Prettyblocks.Admin'),
                'paddings' => $this->trans('Paddings', 'Modules.Prettyblocks.Admin'),
                'top' => $this->trans('Top', 'Modules.Prettyblocks.Admin'),
                'right' => $this->trans('Right', 'Modules.Prettyblocks.Admin'),
                'bottom' => $this->trans('Bottom', 'Modules.Prettyblocks.Admin'),
                'left' => $this->trans('Left', 'Modules.Prettyblocks.Admin'),
                'margins' => $this->trans('Margins', 'Modules.Prettyblocks.Admin'),
                'use_custom_entry' => $this->trans('Use custom entries (px, rem etc..)', 'Modules.Prettyblocks.Admin'),
                'auto_size_section' => $this->trans('Auto sizing', 'Modules.Prettyblocks.Admin'),
                'paddings_section_help' => $this->trans('Padding is the space inside an element, between its content and its boundary', 'Modules.Prettyblocks.Admin'),
                'margins_section_help' => $this->trans('Margin refers to the space outside an element, separating it from other elements', 'Modules.Prettyblocks.Admin'),
                'force_full_width' => $this->trans('Stretch section to 100%', 'Modules.Prettyblocks.Admin'),
                'position_updated' => $this->trans('Position updated successfully', 'Modules.Prettyblocks.Admin'),
                'element_removed' => $this->trans('Element removed successfully', 'Modules.Prettyblocks.Admin'),
                'element_added' => $this->trans('Element added successfully', 'Modules.Prettyblocks.Admin'),
                'error_console' => $this->trans('An error occurred while processing your request', 'Modules.Prettyblocks.Admin'),
                'duplicate_state_error' => $this->trans('An error occurred while duplicating the element', 'Modules.Prettyblocks.Admin'),
                'get_pro' => $this->trans('Get Pro Blocks', 'Modules.Prettyblocks.Admin'),
            ],
            'security_app' => [
                'ajax_token' => Configuration::getGlobalValue('_PRETTYBLOCKS_TOKEN_'),
                'prettyblocks_version' => $module->version,
                'available_language_ids' => $available_language_ids,
                'tinymce_api_key' => 'no-api-key',
            ],
            'prettyblocks' => [
                'assets' => [
                    'css' => $css,
                    'js' => $js,
                    'entrypoint' => $js_entry,
                ],
            ],
        ]);
    }

    private function getAssets(LegacyContext $context): array
    {
        $filesystem = new Filesystem();
        $path = '/modules/prettyblocks/src/Resources/public/';
        $build_dir = _PS_ROOT_DIR_ . $path;
        $build_dir_https = $context->getRootUrl() . ltrim($path, '/');
        $js = [];
        $css = [];
        $js_entry = '';
        if ($filesystem->exists($build_dir)) {
            // load manifest.json
            $manifest = $build_dir . 'manifest.json';

            if (!$filesystem->exists($manifest)) {
                throw new Exception('manifest.json not exist');
            }
            $json = Tools::file_get_contents($manifest);
            $json = json_decode($json, true);

            foreach ($json as $file) {
                if (isset($file['file'])) {
                    if (isset($file['isEntry']) && $file['isEntry']) {
                        $js_entry = $build_dir_https . $file['file'];
                    } else {
                        $js[] = $build_dir_https . $file['file'];
                    }
                }
                if (isset($file['css'])) {
                    foreach ($file['css'] as $entry) {
                        $css[] = $build_dir_https . $entry;
                    }
                }
            }
        }

        return [$css, $js, $js_entry];
    }
}
