<?php

use bbn\Str;
use bbn\Appui\Dashboard;

if (!$model->hasData('idDashboard', true) || !Str::isUid($model->data['idDashboard'])) {
  throw new Exception(_("The dashboard's id is mandatory"));
}
if (!$model->hasData('idWidget', true) || !Str::isUid($model->data['idWidget'])) {
  throw new Exception(_("The widget's id is mandatory"));
}
$dash = new Dashboard($model->data['idDashboard']);
try {
  $id = $dash->addWidget($model->data['idWidget']);
}
catch (Exception $e) {
  return [
    'success' => false,
    'error' => $e->getMessage()
  ];
}

return [
  'success' => true,
  'id' => $id,
  'widgets' => $dash->getWidgets()
];
