<?php
namespace Jankx\FullPage\Features;

use Jankx\Abstractions\Abstracts\Module;
use Jankx\FullPage\Common;
use Jankx\SiteLayout\SiteLayout;

class FullPageMenu extends Module
{
    public function get_name()
    {
        return 'jankx-fullpage-menu';
    }

    public function init()
    {
        register_nav_menu('menu_fullpage', __('FullPage Menu', 'jankx'));

        add_filter('jankx/component/header/preset/default/menu_location', [$this, 'changeMenuLocation']);
        add_filter('jankx/layout/site/menu/itemtypes', [$this, 'addSubmenuFullPage']);

        add_filter('jankx_site_layout_nav_item_callback', function ($callable, $item) {
            if ($item->type !== 'fullpage_submenu') {
                return $callable;
            }
            return [$this, 'render'];
        }, 10, 3);
    }

    public function changeMenuLocation($location)
    {
        if (SiteLayout::getInstance()->getLayout() === Common::LAYOUT_FULL_PAGE) {
            return 'menu_fullpage';
        }
        return $location;
    }

    public function addSubmenuFullPage($items)
    {
        $items['fullpage_submenu'] = __('FullPage Menu', 'jankx');

        return $items;
    }

    public function render($item)
    {
        return apply_filters('the_title', '', $item->ID);
    }
}
