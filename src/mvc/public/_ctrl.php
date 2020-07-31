<?php
/** @var $ctrl \bbn\mvc\controller */
$ok = true;
if ( !defined('APPUI_DASHBOARD_ROOT') ){
  define('APPUI_DASHBOARD_ROOT', $ctrl->plugin_url('appui-dashboard').'/');
  try {
    $ctrl->add_inc('dashboard', new \bbn\appui\dashboard('default'));
  }
  catch ( Exception $e ){
    $ctrl->obj->error = $e->getMessage();
    $ok = false;
  }
}
return $ok;
