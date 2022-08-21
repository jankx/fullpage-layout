<?php
namespace Jankx\FullPage;

use Jankx\Abstractions\Abstracts\Module;
use Jankx\Abstractions\ModuleLoader;
use Jankx\FullPage\Features\FullPageHeader;
use Jankx\FullPage\Features\FullPageMenu;
use Jankx\FullPage\Features\NavigateIcon;

class ModuleManager
{
    protected $modules = [];

    public function initFeatures()
    {
        $this->modules = apply_filters(
            'jankx/fullpage/modules',
            [
                FullPageMenu::class,
                FullPageHeader::class,
                NavigateIcon::class,
            ]
        );
    }

    public function run()
    {
        foreach ($this->modules as $moduleClass) {
            if (!is_a($moduleClass, Module::class, true)) {
                continue;
            }
            new ModuleLoader($moduleClass, 'init');
        }
    }
}
