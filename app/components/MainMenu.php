<?php

class MainMenu extends CWidget {

    public $menuItems;
    public $subMenuItems;

    public function init() {
        $this->menuItems = array(
            array('label' => 'Projects', 'url' => array('/cms/project/index')),
            array('label' => 'Project types', 'url' => array('/cms/type/index')),
           /* array('label' => 'Administrator', 'url' => array('/admin/index'), 'visible' => _user()->role >= Role::ADMIN,
                'items' => array(
                    array('label' => 'View logs', 'url' => array('/admin/logs')),
                    array('label' => 'System settings', 'url' => array('/admin/system')),
                    array('label' => 'Users', 'url' => array('/admin/users')),
            )),
           */
        );
        Utils::triggerEvent('onIndexMenu', $this);
    }

    public function run() {
        $this->render('mainMenu');
    }

    public function addMenuItem(array $item) {
        $this->menuItems[] = $item;
    }
}