<?php
namespace Jankx\FullPage;

class Loader
{
    protected static $instance;

    protected function __construct()
    {
    }

    public function getInstance() {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
