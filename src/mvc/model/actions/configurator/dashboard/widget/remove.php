<?php
if (!$model->hasData('idDashboard', true) || !\bbn\Str::isUid($model->data['idDashboard'])) {
  throw new \Exception(_("The dashboard's id is mandatory"));
}
if (!$model->hasData('idWidget', true) || !\bbn\Str::isUid($model->data['idWidget'])) {
  throw new \Exception(_("The widget's id is mandatory"));
}
$dash = new \bbn\Appui\Dashboard($model->data['idDashboard']);
return ['success' => $dash->deleteWidget($model->data['idWidget'])];