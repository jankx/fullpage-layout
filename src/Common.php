<?php

namespace Jankx\FullPage;

use Jankx\SiteLayout\SiteLayout;

class Common
{
    const LAYOUT_FULL_PAGE = 'jankx-fullpage';

    protected static $isFullPageLayout;

    public static function isFullPageLayout()
    {
        if (is_null(static::$isFullPageLayout)) {
            $layout = SiteLayout::getInstance()->getLayout(false);
            if (!is_null($layout)) {
                static::$isFullPageLayout = ($layout === self::LAYOUT_FULL_PAGE);
            }
        }
        return static::$isFullPageLayout;
    }
}
