<?php
/*
 *  Describe what it does
 *
 **/

use bbn\X;
use bbn\User\Permissions;
use bbn\Appui\Dashboard;
/** @var bbn\Mvc\Controller $ctrl */

$dashboard = new Dashboard('default');
$widgets = $dashboard->getWidgets();
$o = $ctrl->inc->options;
if (!isset($ctrl->inc->perm)) {
  $ctrl->addInc('perm', new Permissions($ctrl->getRoutes()));
}
foreach ($widgets as $w) {
  if (!empty($w['cache'])) {
    $code = $w['code'];
    $ctrl->getTimer()->start('widget ' . $code);
    $dashboard->deleteWidgetCache($w['id_option'], $ctrl);
    $dashboard->getWidgetData($w['id_option'], $ctrl, empty($w['limit']) ? [] : ['start' => 0, 'limit' => $w['limit']]);
    $ctrl->getTimer()->stop('widget ' . $code);
  }
}
X::adump($ctrl->getTimer()->results());
