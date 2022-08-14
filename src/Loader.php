<?php
namespace Jankx\FullPage;

class Loader
{
    protected static $instance;

    protected function __construct()
    {
        $this->initHooks();
    }

    public function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function initHooks()
    {
        add_action('init', [$this, 'init']);
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
    }
}
