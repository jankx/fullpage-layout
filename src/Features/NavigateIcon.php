<?php
namespace Jankx\FullPage\Features;

use Jankx\Abstractions\Abstracts\Module;
use Jankx\FullPage\Common;
use Jankx\GlobalVariables;

class NavigateIcon extends Module
{
    protected static $lastIconAction;

    public function get_name()
    {
        'jankx-fullpage-navigate-icon';
    }

    protected function getLastIconAction()
    {
        if (is_null(static::$lastIconAction)) {
            static::$lastIconAction = GlobalVariables::get('fullpage.navigate.lastAction', 'top');
        }
        return static::$lastIconAction;
    }

    public function frontend_init()
    {
        if (Common::isFullPageLayout()) {
            add_action('wp_footer', [$this, 'printIcon']);
        }
    }

    public function printLastIcon()
    {
        ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path fill="currentColor" d="M54.9,49.8H25.3L40,24.1L54.9,49.8z M30.7,46.5h18.6l-9.4-16.1L30.7,46.5z"></path></svg>
        <?php
    }

    public function printIcon()
    {
        ?>
        <div class="jankx-fullpage-navigate">
            <div class="navigate-icon">
            <div class="wheel"><span></span><span></span><span></span></div>
            </div>
            <div class="navigate-icon <?php echo $this->getLastIconAction(); ?>">
                <?php $this->printLastIcon(); ?>
            </div>
        </div>
        <?php
    }
}
