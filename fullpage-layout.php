<?php

use Jankx\FullPage\Loader;

if (class_exists(Loader::class)) {
    add_action(
        'after_setup_theme',
        [Loader::class, 'getInstance']
    );
}
