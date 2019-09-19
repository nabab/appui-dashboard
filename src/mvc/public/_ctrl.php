<?php
/** @var $ctrl \bbn\mvc\controller */
if ( !defined('APPUI_DASHBOARD_ROOT') ){
  define('APPUI_DASHBOARD_ROOT', $ctrl->plugin_url('appui-dashboard').'/');
  $ctrl->add_inc('dashboard', new \bbn\appui\dashboard());
}
