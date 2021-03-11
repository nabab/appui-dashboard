<?php
if (!$model->hasData('idDashboard', true) || !\bbn\Str::isUid($model->data['idDashboard'])) {
  throw new \Exception(_("The dashboard's id is mandatory"));
}
if (!$model->hasData('idWidget', true) || !\bbn\Str::isUid($model->data['idWidget'])) {
  throw new \Exception(_("The widget's id is mandatory"));
}
$dash = new \bbn\Appui\Dashboard($model->data['idDashboard']);
if ($id = $dash->addWidget($model->data['idWidget'])) {
  return [
    'success' => true,
    'id' => $id,
    'widgets' => $dash->getWidgets()
  ];
}
return ['success' => false];