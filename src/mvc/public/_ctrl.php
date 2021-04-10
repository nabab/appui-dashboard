<?php
/** @var $ctrl \bbn\Mvc\Controller */
$ok = true;
if ( !defined('APPUI_DASHBOARD_ROOT') ){
  define('APPUI_DASHBOARD_ROOT', $ctrl->pluginUrl('appui-dashboard').'/');
  if (!empty($ctrl->post['id_dashboard'])) {
    $id = $ctrl->post['id_dashboard'];
  }
  elseif ($ctrl->hasArguments() && ($ctrl->getPath() === 'home')) {
    $id = $ctrl->arguments[0];
  }
  else {
    $id = 'default';
  }

  try {
    $ctrl->addInc('dashboard', new \bbn\Appui\Dashboard($id));
  }
  catch (Exception $e) {
    $ctrl->obj->error = $e->getMessage();
    $ok = false;
  }
}

return $ok;
