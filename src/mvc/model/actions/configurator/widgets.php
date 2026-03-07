<?php

use bbn\Str;
use bbn\Appui\Dashboard;

$res = ['success' => false];

/** @var bbn\Mvc\Model $model */
if ($model->hasData('action', true)) {
  /** @var bbn\Appui\Option $o */
  $o = $model->inc->options;
  $optCfg = $o->getClassCfg();
  $optFields = $optCfg['arch']['options'];
  $dash = new Dashboard();
  switch ($model->data['action']) {
    case 'insert':
      if (!$model->hasData($optFields['text'], true)) {
        $res['error'] = sprintf(_("The %s property is mandatory"), $optFields['text']);
        return $res;
      }

      $idParent = empty($model->data[$optFields['id_parent']])
        ? $o->fromCode('widgets', 'dashboard', 'appui')
        : $model->data[$optFields['id_parent']];
      if (empty($model->data[$optFields['id_parent']])
        && $model->hasData('plugin', true)
        && ($model->data['plugin'] !== $model->pluginUrl('appui-dashboard'))
        && ($pluginName = $model->pluginName($model->data['plugin']))
      ) {
        $isAppuiPlugin = Str::pos($pluginName, 'appui-') === 0;
        if ($isAppuiPlugin) {
          $pluginName = Str::sub($pluginName, 6);
        }

        if ($p = $o->fromCode('plugins', $pluginName, $isAppuiPlugin ? 'appui' : 'plugins')) {
          if (!$appuiDashboard = $o->fromCode('appui-dashboard', $p)) {
            $appuiDashboard = $o->add([
              $optFields['id_parent'] => $p,
              $optFields['code'] => 'appui-dashboard',
              $optFields['text'] => 'Dashboard',
              $optFields['id_alias'] => $o->fromCode('dashboard', 'appui')
            ]);
          }

          if (Str::isUid($appuiDashboard)) {
            if (!$appuiDashboardWidgets = $o->fromCode('widgets', $appuiDashboard)) {
              $appuiDashboardWidgets = $o->add([
                $optFields['id_parent'] => $appuiDashboard,
                $optFields['code'] => 'widgets',
                $optFields['text'] => 'Widgets',
                $optFields['id_alias'] => $o->fromCode('widgets', 'dashboard', 'appui')
              ]);
            }

            if (Str::isUid($appuiDashboardWidgets)) {
              $idParent = $appuiDashboardWidgets;
            }
          }
        }
      }

      if ($model->hasData('isContainer', true)) {
        try {
          $res['success'] = !!$o->add([
            $optFields['text'] => $model->data[$optFields['text']],
            $optFields['code'] => $model->data[$optFields['code']] ?: null,
            $optFields['id_parent'] => $idParent,
            'isContainer' => true
          ]);
        }
        catch (Exception $e) {
          $res['error'] = $e->getMessage();
        }
      }
      else {
        unset($model->data['res'], $model->data['action']);
        $model->data[$optFields['id_parent']] = $idParent;
        try {
          $res['success'] = $dash->addNativeWidget($model->data);
        }
        catch (Exception $e) {
          $res['error'] = $e->getMessage();
        }
      }

      break;

    case 'update':
      if (!$model->hasData($optFields['id'], true)) {
        $res['error'] = sprintf(_("The %s property is mandatory"), $optFields['id']);
      }
      elseif (!$model->hasData($optFields['text'], true)) {
        $res['error'] = sprintf(_("The %s property is mandatory"), $optFields['text']);
      }
      elseif ($model->hasData('isContainer', true)) {
        unset($model->data['res'], $model->data['action']);
        try {
          $res['success'] = !!$o->set($model->data[$optFields['id']], $model->data);
        }
        catch (Exception $e) {
          $res['error'] = $e->getMessage();
        }
     }
      else {
        try {
          $res['success'] = !!$o->set($model->data[$optFields['id']], $model->data);
        }
        catch (Exception $e) {
          $res['error'] = $e->getMessage();
        }
      }

      break;

    case 'delete':
      try {
        $res['success'] = $dash->deleteNativeWidget($model->data[$optFields['id']]);
      }
      catch (Exception $e) {
        $res['error'] = $e->getMessage();
      }

      break;

    case 'move':
      try {
        $res['success'] = $dash->moveNativeWidget($model->data[$optFields['id']], $model->data[$optFields['id_parent']]);
      }
      catch (Exception $e) {
        $res['error'] = $e->getMessage();
      }

      break;
  }
}

return $res;
