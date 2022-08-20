<?php
namespace Jankx\FullPage;

use Jankx\FullPage\Features\FullPageMenu;

class ModuleManager
{
    protected $modules = [];

    public function initFeatures()
    {
        $this->modules = apply_filters(
            'jankx/fullpage/modules',
            [
                FullPageMenu::class,
            ]
        );
    }

    public function run()
    {
        foreach ($this->modules as $moduleClass) {
            if (!is_a($moduleClass, Module::class)) {
                continue;
            }
        }
    }
}
