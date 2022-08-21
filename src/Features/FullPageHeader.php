<?php
namespace Jankx\FullPage\Features;

use Jankx\Abstractions\Abstracts\Module;
use Jankx\FullPage\Mobile\MenuLayout;

class FullPageHeader extends Module
{
    public function get_name()
    {
        return 'jankx-fullpage-header';
    }

    public function init()
    {
        add_filter('jankx/layout/site/mobile/menu/apply', function () {
            return MenuLayout::class;
        });
        add_filter('jankx/template/header/mobile/enabled', '__return_false');
    }
}
