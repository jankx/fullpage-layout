<?php

use Jankx\FullPage\Loader;

define('JANKX_FULL_PAGE_LAYOUT_LOADER', __FILE__);

if (class_exists(Loader::class)) {
    add_action(
        'after_setup_theme',
        [Loader::class, 'getInstance']
    );
}
