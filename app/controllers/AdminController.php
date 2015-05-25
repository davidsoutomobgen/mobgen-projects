<?php

class AdminController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('deny',
                'actions' => array('users', 'addUser', 'editUser', 'deleteUser'),
                'expression' => '_user()->role != Role::ADMIN',
            ),
            array('allow',
                'expression' => '_user()->role == Role::ADMIN || _user()->role == Role::DEV',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function init() {
        $this->pageTitle = Yii::app()->name;
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogs() {
        $log = $this->_getLog();
        $logScript = $this->_getScriptLog();
        $this->render('logs', array('log' => $log, 'logScript' => $logScript));
    }

    public function actionLoadLog($type = 'logs') {
        switch ($type) {
            case 'logs':
                $log = $this->_getLog();
                break;
            case 'logs-script':
                $log = $this->_getScriptLog();
                break;
        }

        $this->renderPartial('_log', array('log' => $log));
    }

    private function _getLog() {
//		$file = _bp('runtime/mobgen.log');
		$file = _param('logPath'). DS .'mobgen.log';
		$log = null;

        if (file_exists($file)) {
            $lines = file($file);
            $log = implode('<br />', array_reverse(CHtml::encodeArray($lines)));
        }

        if ($log) {
            $log = preg_replace('/(\w{3}\s\d{2}\s\d{2}:\d{2}:\d{2}\s)/', '<strong>${1}</strong>', $log);
            $log = preg_replace('/(&lt;I&gt;.*)/', '<span class="info">${1}</span>', $log);
            $log = preg_replace('/(&lt;W&gt;.*)/', '<span class="warning">${1}</span>', $log);
            $log = preg_replace('/(&lt;E&gt;.*)/', '<span class="error">${1}</span>', $log);
        }

        return $log;
    }

    private function _getScriptLog() {
//		$fileScript = _bp('runtime/mobgen-script.log');
		$fileScript = _param('logPath'). DS .'mobgen-script.log';

        $logScript = null;

        if (file_exists($fileScript)) {
            $lines = file($fileScript);
            $logScript = implode('<br />', array_reverse(CHtml::encodeArray($lines)));
        }

        if ($logScript) {
            $logScript = preg_replace('/(\w{3}\s\d{2}\s\d{2}:\d{2}:\d{2}\s)/', '<strong>${1}</strong>', $logScript);
            $logScript = preg_replace('/(&lt;I&gt;.*)/', '<span class="info">${1}</span>', $logScript);
            $logScript = preg_replace('/(&lt;W&gt;.*)/', '<span class="warning">${1}</span>', $logScript);
            $logScript = preg_replace('/(&lt;E&gt;.*)/', '<span class="error">${1}</span>', $logScript);
        }

        return $logScript;
    }

    public function actionSystem() {
        Utils::registerCssFile('form');
        $system = System::model()->find();

        if (isset($_POST['System'])) {
            $system->attributes = $_POST['System'];
            $system->save();
        }

        $this->render('system', array('system' => $system));
    }

    public function actionAddUser() {
        Utils::registerCssFile('form');
        $user = new Webuser;

        if (isset($_POST['Webuser'])) {
            $user->attributes = $_POST['Webuser'];
            $user->last_login = date(DATE_ISO8601);
            $user->save();

            $this->redirect('users');
        }

        $this->render('user', array('user' => $user));
    }

    public function actionUsers() {
        $users = new Webuser('search');

        $this->render('users', array('users' => $users));
    }

    public function actionEditUser($id) {
        Utils::registerCssFile('form');
        $user = Webuser::model()->findByPk($id);

        if (isset($_POST['Webuser'])) {
            $user->attributes = $_POST['Webuser'];
            $user->last_login = date(DATE_ISO8601);
            $user->save();

            $this->redirect('users');
        }

        $this->render('user', array('user' => $user));
    }

    public function actionDeleteUser($id) {
        Webuser::model()->deleteByPk($id);

        $this->redirect('users');
    }

}