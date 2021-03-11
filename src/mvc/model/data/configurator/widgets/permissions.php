<?php
if (!$model->hasData('id', true)) {
  throw new \Exception(_("The 'id' field is mandatory"));
}
if (!($idPerm = $model->inc->perm->optionToPermission($model->data['id']))) {
  throw new \Exception(sprintf(_("No permission record for id: %s"), $model->data['id']));
}
return $model->getModel($model->pluginUrl('appui-option') . '/permissions/actions/get', [
  'id' => $model->data['id'],
  'full' => 1
]);