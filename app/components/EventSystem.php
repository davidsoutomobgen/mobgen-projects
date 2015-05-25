<?php

class EventSystem extends CApplicationComponent {

    /**
     * Items
     */
    public function onAfterNewItems($event) {
        $this->raiseEvent('onAfterNewItems', $event);
    }

    /**
     * Menu
     */
    public function onIndexMenu($event) {
        $this->raiseEvent('onIndexMenu', $event);
    }

    public function onDataEntryMenu($event) {
        $this->raiseEvent('onDataEntryMenu', $event);
    }

    /**
     * Push
     * @param type $event 
     */
    public function onRegisterToken($event) {
        $this->raiseEvent('onRegisterToken', $event);
    }

}

?>
