<?php
use bbn\X;

/** @var bbn\Mvc\Controller $ctrl */
$ok = true;
if (!defined('APPUI_DASHBOARD_ROOT')) {
  define('APPUI_DASHBOARD_ROOT', $ctrl->pluginUrl('appui-dashboard').'/');
  $ctrl->addInc('dashboard', new \bbn\Appui\Dashboard());
  if (!empty($ctrl->post['id_dashboard'])) {
    $id = $ctrl->post['id_dashboard'];
  }
  elseif ($ctrl->hasArguments() && ($ctrl->getPath() === 'home')) {
    $id = $ctrl->arguments[0];
  }
  else {
    if (!$id = $ctrl->inc->dashboard->getDefault()) {
      $dashboards = $ctrl->inc->dashboard->getUserDashboards();
      if (X::getRow($dashboards, ['code' => 'default'])) {
        $id = 'default';
      }
      elseif (!empty($dashboards)) {
        $id = $dashboards[0]['id'];
      }  
    }
  }

  if ($id) {
    try {
      $ctrl->inc->dashboard->setCurrent($id);
    }
    catch (Exception $e) {
      $ctrl->obj->error = $e->getMessage();
      $ok = false;
    }
  }
}

return $ok;
