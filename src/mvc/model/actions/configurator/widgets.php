<?php
$success = false;
if ($model->hasData('action', true)) {
  $optCfg = $model->inc->options->getClassCfg();
  $optFields = $optCfg['arch']['options'];
  $dash = new \bbn\Appui\Dashboard();
  switch ($model->data['action']) {
    case 'insert':
      if (!$model->hasData($optFields['text'], true)) {
        throw new \Exception(sprintf(_("The %s property is mandatory"), $optFields['text']));
      }
      if ($model->hasData('isContainer', true)) {
        $success = !!$model->inc->options->add([
          $optFields['text'] => $model->data[$optFields['text']],
          $optFields['code'] => $model->data[$optFields['code']] ?: null,
          $optFields['id_parent'] => empty($model->data[$optFields['id_parent']])
            ? $model->inc->options->fromCode('widgets', 'dashboard', 'appui')
            : $model->data[$optFields['id_parent']]
        ]);
      }
      else {
        unset($model->data['res'], $model->data['action']);
        $success = $dash->addNativeWidget($model->data);
      }
      break;
    case 'update':
      if (!$model->hasData($optFields['id'], true)) {
        throw new \Exception(sprintf(_("The %s property is mandatory"), $optFields['id']));
      }
      if (!$model->hasData($optFields['text'], true)) {
        throw new \Exception(sprintf(_("The %s property is mandatory"), $optFields['text']));
      }
      if ($model->hasData('isContainer', true)) {
        unset($model->data['res'], $model->data['action'], $model->data['isContainer']);
        $success = !!$model->inc->options->set($model->data[$optFields['id']], $model->data);
      }
      else {
        $success = $dash->updateNativeWidget($model->data[$optFields['id']], $model->data);
      }
      break;
    case 'delete':
      $success = $dash->deleteNativeWidget($model->data[$optFields['id']]);
      break;
  }
}
return [
  'success' => $success
];