<?php

abstract class WebModule extends CWebModule {

    /**
     * @var bool Whether to auto initialise the module or not.
     */
    public $autoinit = false;

    /**
     * @var array Other module that this module depends on.
     */
    public $dependencies = array();

    /**
     *
     */
    public function init() {
        $this->checkDependencies();
    }

    /**
     * Preloads child modules.
     */
    protected function preloadModules() {
        foreach ($this->getModules() as $name => $module) {
            if (isset($module['autoinit']) && $module['autoinit'] === true) {
                $this->getModule($name);
            }
        }
    }

    /**
     * Checks for dependant modules.
     */
    private function checkDependencies() {
        foreach ($this->dependencies as $dep) {
            if (!_isModuleOn($dep))
                throw new CException("Dependency failed for module '{$this->name}': missing module '{$dep}'");
        }
    }

}
