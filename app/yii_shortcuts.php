<?php

/**
 * This is the shortcut to Yii::app()
 */
function _app() {
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function _cs() {
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 */
function _user() {
    return Yii::app()->getUser();
}

/**
 * This is the shortcut to _url()
 */
function _url($route, $params=array(), $ampersand='&') {
    return Yii::app()->createUrl($route, $params, $ampersand);
}

/**
 * This is the shortcut to CHtml::encode
 */
function _h($text) {
    return htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset);
}

/**
 * This is the shortcut to CHtml::link()
 */
function _l($text, $url = '#', $htmlOptions = array()) {
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function _t($message, $params = array(), $category = 'default', $source = null, $language = null) {
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to _bu()
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function _bu($url=null) {
    static $baseUrl;
    if ($baseUrl === null)
        $baseUrl = Yii::app()->getRequest()->getBaseUrl();
    return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Shortcut to basepath
 */
function _bp($path=null) {
    static $basePath;
    if ($basePath === null)
        $basePath = Yii::app()->getBasePath();
    return $path === null ? $basePath : $basePath . '/' . ltrim($path, '/');
}

/**
 * Shortcut to theme base url. Defaults to base url if theme is not available.
 */
function _tbu($url=null) {
    static $baseUrl;
    if ($baseUrl === null) {
        if (_app()->theme == null)
            $baseUrl = Yii::app()->getRequest()->getBaseUrl();
        else
            $baseUrl = Yii::app()->theme->baseUrl;
    }
    return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function _param($name) {
    return Yii::app()->params[$name];
}

function _redirect($url, $params=array()) {
    Yii::app()->request->redirect(_url($url, $params));
}

function _home() {
    Yii::app()->request->redirect(Yii::app()->homeUrl);
}

function _logout() {
    _redirect('user/logout');
}

/**
 * @return WebModule
 */
function _module() {
    return _controller()->module;
}

function _module_id() {
    return _controller()->module->id;
}

function _controller_id() {
    return _app()->getController()->id;
}

/**
 * @return Controller
 */
function _controller() {
    return _app()->getController();
}

function _action_id() {
    return _app()->getController()->getAction()->id;
}

function _return() {
    Yii::app()->request->redirect(_user()->returnUrl);
}

function _is_logged_in() {
    return!_user()->isGuest;
}


function _isModuleOn($name) {
    return
        isset(_app()->modules[$name]) ||
        (isset(_app()->params['features'][$name]) && _app()->params['features'][$name] == true);
}

function _moduleUrl($module) {
    return _bu() . '/protected/modules/' . $module . '/';
}

function _setPageTitle($title = '') {
    _controller()->pageTitle = _app()->name;
    if ($title != '') {
        _controller()->pageTitle .= ' - ' . $title;
    }
}

/**
 * Converts the first letter of a UTF-8 string to uppercase.
 * @param string $str
 * @return string
 */
function mb_ucfirst($str) {
    return mb_convert_case($str, MB_CASE_TITLE);
}

function _dump($var, $die = false, $echo = true) {
    $display = $echo ? CVarDumper::dump($var, 10, true) : CVarDumper::dumpAsString($var, 10, true);
    if ($die)
        die();
    return $display;
}

?>
