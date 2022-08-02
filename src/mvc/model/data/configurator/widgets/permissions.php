<?php
if (!$model->hasData('id', true)) {
  throw new \Exception(_("The 'id' field is mandatory"));
}

$idPerm = $model->inc->perm->optionToPermission($model->data['id'], true);

if (empty($idPerm)) {
  throw new \Exception(sprintf(_("No permission record for id: %s"), $model->data['id']));
}

return $model->getModel($model->pluginUrl('appui-option') . '/permissions/actions/get', [
  'id' => $idPerm,
  'full' => 1
]);
