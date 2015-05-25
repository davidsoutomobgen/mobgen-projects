<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $layout = '//layouts/main';
    public $customHeader = false;

    protected function beforeAction($action) {
        if ($action->controller->id == 'api' || $action->id == 'error') {
            Yii::log('Request from: ' . _app()->request->userHostAddress . '[' . _app()->request->userAgent . '] , Request was: ' . _app()->request->url, CLogger::LEVEL_INFO, 'mobgen');
        }

        return parent::beforeAction($action);
    }

    protected function afterAction($action) {
        parent::afterAction($action);
        if (YII_PROFILE) {
            Yii::endProfile($this->action->id);
            $this->render('debug');
            Yii::app()->end();
        }
    }

    protected function _sendResponse($status = 200, $body = '', $logMessage = null, $content_type = 'application/json') {
        $apiResponse = new ApiResponse;
        $apiResponse->customHeader = $this->customHeader;

        if ($logMessage) {
            if (is_array($logMessage)) {
                $log =  $logMessage;
                $logMessage = '';
                foreach ($log as $msg) {
                    foreach ($msg as $err)
                        $logMessage .= ' ' . $err;
                }
            }
            Yii::log("Error {$status} on {$this->action->id}: {$logMessage}", CLogger::LEVEL_ERROR, 'mobgen');
        }

        $apiResponse->sendResponse($status, $body, $content_type);

        return;
    }

    public function preloadModules() {
        foreach (_app()->getModules() as $name => $module) {
            if (isset($module['autoinit']) && $module['autoinit'] === true) {
                _app()->getModule($name);
            }
        }
    }

    public function filterHttps($filterChain) {
        $filter = new HttpsFilter;
        $filter->filter($filterChain);
    }

    // creates a JSON success message
    protected function createSuccessArray($message = '') {
        return array(
            'error' => false,
            'code' => 0,
            'message' => $message
        );
    }

}