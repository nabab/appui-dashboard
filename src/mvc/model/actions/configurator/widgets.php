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
      $idParent = empty($model->data[$optFields['id_parent']])
        ? $model->inc->options->fromCode('widgets', 'dashboard', 'appui')
        : $model->data[$optFields['id_parent']];
      if (empty($model->data[$optFields['id_parent']])
        && $model->hasData('plugin', true)
        && ($model->data['plugin'] !== $model->pluginUrl('appui-dashboard'))
        && ($pluginName = $model->pluginName($model->data['plugin']))
      ) {
        $isAppuiPlugin = strpos($pluginName, 'appui-') === 0;
        if ($isAppuiPlugin) {
          $pluginName = substr($pluginName, 6);
        }
        if ($p = $model->inc->options->fromCode('plugins', $pluginName, $isAppuiPlugin ? 'appui' : 'plugins')) {
          if (!$appuiDashboard = $model->inc->options->fromCode('appui-dashboard', $p)) {
            $appuiDashboard = $model->inc->options->add([
              $optFields['id_parent'] => $p,
              $optFields['code'] => 'appui-dashboard',
              $optFields['text'] => 'Dashboard',
              $optFields['id_alias'] => $model->inc->options->fromCode('dashboard', 'appui')
            ]);
          }
          if (\bbn\Str::isUid($appuiDashboard)) {
            if (!$appuiDashboardWidgets = $model->inc->options->fromCode('widgets', $appuiDashboard)) {
              $appuiDashboardWidgets = $model->inc->options->add([
                $optFields['id_parent'] => $appuiDashboard,
                $optFields['code'] => 'widgets',
                $optFields['text'] => 'Widgets',
                $optFields['id_alias'] => $model->inc->options->fromCode('widgets', 'dashboard', 'appui')
              ]);
            }
            if (\bbn\Str::isUid($appuiDashboardWidgets)) {
              $idParent = $appuiDashboardWidgets;
            }
          }
        }
      }
      if ($model->hasData('isContainer', true)) {
        $success = !!$model->inc->options->add([
          $optFields['text'] => $model->data[$optFields['text']],
          $optFields['code'] => $model->data[$optFields['code']] ?: null,
          $optFields['id_parent'] => $idParent,
          'isContainer' => true
        ]);
      }
      else {
        unset($model->data['res'], $model->data['action']);
        $model->data[$optFields['id_parent']] = $idParent;
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
        unset($model->data['res'], $model->data['action']);
        $success = !!$model->inc->options->set($model->data[$optFields['id']], $model->data);
      }
      else {
        $success = $dash->updateNativeWidget($model->data[$optFields['id']], $model->data);
      }
      break;
    case 'delete':
      $success = $dash->deleteNativeWidget($model->data[$optFields['id']]);
      break;
    case 'move':
      $success = $dash->moveNativeWidget($model->data[$optFields['id']], $model->data[$optFields['id_parent']]);
      break;
  }
}
return [
  'success' => $success
];