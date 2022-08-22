<?php
namespace Jankx\FullPage;

use Jankx;
use Jankx\Asset\Bucket;
use Jankx\GlobalVariables;
use Jankx\SiteLayout\SiteLayout;

class Loader
{
    protected static $instance;

    protected static $enabled;

    protected static $currentLayout;
    protected static $fullPageDirUrl;
    protected static $fullPageAssetDirUrl;

    protected function __construct()
    {
        $this->bootstrap();
        $this->initHooks();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function bootstrap()
    {
        static::$fullPageDirUrl = jankx_get_path_url(dirname(JANKX_FULL_PAGE_LAYOUT_LOADER));
        static::$fullPageAssetDirUrl = sprintf('%s/assets', static::$fullPageDirUrl);

        $moduleManager = new ModuleManager();
        $moduleManager->initFeatures();
        $moduleManager->run();
    }

    protected function getCurrentLayout()
    {
        if (is_null(static::$currentLayout)) {
            static::$currentLayout = SiteLayout::getInstance()->getLayout();
        }
        return static::$currentLayout;
    }

    protected function initHooks()
    {
        add_action('init', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'registerScripts']);
        add_filter('jankx/template/page/header/name', [$this, 'changeHeaderAndFooterStyleToFullPage']);
        add_filter('jankx/template/page/footer/name', [$this, 'changeHeaderAndFooterStyleToFullPage']);
    }

    public function init()
    {
        add_filter('jankx/site/layouts', function ($layouts) {
            $layouts[Common::LAYOUT_FULL_PAGE] = __('Full Page', 'jankx');

            return $layouts;
        });
        add_filter('jankx/layout/full_width', function ($layouts) {
            $layouts[] = Common::LAYOUT_FULL_PAGE;

            return $layouts;
        });
        add_filter('body_class', array($this, 'bodyClasses'));
    }

    public function bodyClasses($classes)
    {
        if ($this->getCurrentLayout() === Common::LAYOUT_FULL_PAGE) {
            $classes[] = SiteLayout::LAYOUT_FULL_WIDTH;
        }
        return $classes;
    }

    public function getAssetUrl($path = '')
    {
        if (empty($path)) {
            return static::$fullPageAssetDirUrl;
        }
        return static::$fullPageAssetDirUrl . '/' . $path;
    }

    public function registerScripts()
    {
        if ($this->getCurrentLayout() !== Common::LAYOUT_FULL_PAGE) {
            return;
        }
        $assetBucket = Bucket::instance();
        $assetBucket->js('fullpage', $this->getAssetUrl('lib/fullPagejs/fullpage.min.js'), [], '4.0.10', true);
        $assetBucket->js('jankx-fullpage-layout', $this->getAssetUrl('js/jankx-fullpage-layout.js'), ['fullpage'], '1.0.0.19', true)
            ->localize(
                'jankxFullpage',
                apply_filters('jankx/fullpage/objects', [
                    'navigation' => true,
                    'navigationPosition' => 'right',
                    'backendEnabled' => static::checkFullPageEnabled(),
                    'mobileAllowed' => static::checkMobileIsAllow(),
                    'mobileBreakpoint' => 678,
                    'lastSlideAction' => GlobalVariables::get('fullpage.navigate.lastAction', 'top'),
                ], $this->getCurrentLayout())
            )
            ->enqueue();

        $assetBucket->css('fullpage', $this->getAssetUrl('lib/fullPagejs/fullpage.min.css'), [], '4.0.10');
        $assetBucket->css('jankx-fullpage-layout', $this->getAssetUrl('css/jankx-fullpage-layout.css'), ['fullpage'], '1.0.0.19')
            ->enqueue();
    }

    public function changeHeaderAndFooterStyleToFullPage($headerStyle)
    {
        if ($this->getCurrentLayout() === Common::LAYOUT_FULL_PAGE) {
            return 'fullpage';
        }
        return $headerStyle;
    }

    public static function checkMobileIsAllow()
    {
        return apply_filters('jankx/site/layout/fullpage/mobile/enabled', false);
    }

    /**
     * @return boolean
     */
    public static function checkFullPageEnabled()
    {
        if (is_null(static::$enabled)) {
            static::$enabled = !Jankx::device()->isMobile() || static::checkMobileIsAllow();
        }
        return boolval(static::$enabled);
    }
}
