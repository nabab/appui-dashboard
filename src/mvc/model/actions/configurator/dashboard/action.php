<?php
use \bbn\Appui\Dashboard;
$success = false;
if ($model->hasData('action', true)) {
  $prefFields = $model->inc->pref->getClassCfg()['arch']['user_options'];
  switch ($model->data['action']) {
    case 'insert':
      if ($model->hasData([$prefFields['text'], 'code'], true)) {
        $dash = new Dashboard();
        if ($id = $dash->insert([
          $prefFields['text'] => $model->data[$prefFields['text']],
          'code' => $model->data['code'],
          $prefFields['public'] => $model->data[$prefFields['public']],
          $prefFields['id_user'] => $model->data[$prefFields['id_user']] ?: null,
          $prefFields['id_group'] => $model->data[$prefFields['id_group']] ?: null
        ])) {
          $success = true;
        }
      }
      break;
    case 'update':
      if ($model->hasData([$prefFields['id'], $prefFields['text'], 'code'], true)) {
        $dash = new Dashboard($model->data[$prefFields['id']]);
        $toUpd = [
          $prefFields['text'] => $model->data[$prefFields['text']],
          'code' => $model->data['code'],
          $prefFields['public'] => $model->data[$prefFields['public']],
          $prefFields['id_user'] => $model->data[$prefFields['id_user']] ?: null,
          $prefFields['id_group'] => $model->data[$prefFields['id_group']] ?: null
        ];
        if ($id = $dash->update($toUpd)) {
          $success = true;
        }
      }
      break;
    case 'delete':
      if ($model->hasData($prefFields['id'], true)) {
        $dash = new Dashboard($model->data[$prefFields['id']]);
        $success = $dash->delete();
      }
      break;
  }
}
return [
  'success' => $success
];