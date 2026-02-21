<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 05/06/2017
 * Time: 16:20
 */

use bbn\X;
use bbn\Str;
use function is_array;
use function count;

/** @var bbn\Appui\Dashboard $dash */
$dash = $model->inc->dashboard;
/** @var bbn\Appui\Option $o */
$o = $model->inc->options;
/** @var array $res */
$res = ['success' => false];
/** @var bbn\Mvc\Model $model */
$model->timer->reset();
$model->timer->start('start', constant('BBN_START_TIME'));
$model->timer->stop('start');
$model->timer->start('global');
$model->timer->start('widgetOption');
if ($model->hasData('key', true)
  && $dash
  && ($idWidget = $dash->getWidgetOption($model->data['key']) ?: $model->data['key'])
) {
  $model->timer->stop('widgetOption');
  $model->timer->start('widgetPref');
  // Fetches the permission's alias: widget in dashboard options
  if ($info = $o->option($idWidget)) {
    $id_perm = $model->inc->perm->optionToPermission($idWidget);
    $code    = $info['code'];
    if ($pref = $model->inc->pref->getByOption($idWidget)) {
      $info = X::mergeArrays($info, $pref);
    }
  }
  // Otherwise checking if the key is a preference
  elseif ($info = $model->inc->pref->get($idWidget)) {
    $id_perm = $info['id_option'];
    $code    = $info['widget']['code'];
  }
  // User's private widget
  elseif ($info = $dash->getPvtWidget($idWidget)) {
    $code = !empty($info['code']) ? $info['code'] : false;
  }

  $model->timer->stop('widgetPref');
  $model->timer->start('lastPart');
  if (!empty($code)
    && ($dash->isPvtWidget($idWidget)
      || (!empty($id_perm)
        && $model->inc->perm->has($id_perm)))
  ) {
    if (!empty($id_perm)
      && ($id_plugin = $o->getParentPlugin($id_perm))
    ) {
      $plugin = $o->getPluginName($id_plugin);
      if ($plugin === 'appui-dashboard') {
        $model->timer->start('model');
        if (!($res = $model->getPluginModel($code, $model->data, $model->pluginUrl('appui-dashboard'), $info['cache'] ?? 0))) {
          if (!empty($info['cache'])) {
            $res = $model->getCachedModel(APPUI_DASHBOARD_ROOT."/data/$code", $info['cache']);
          }
          else {
            $res = $model->getModel(APPUI_DASHBOARD_ROOT."/data/$code");
          }
        }
        $model->timer->stop('model');
      }
      else {
        $model->timer->start('model');
        $res = $model->getSubpluginModel($code, $model->data, $plugin, 'appui-dashboard', $info['cache'] ?? 0);
        $model->timer->stop('model');
      }
      /*
      if (X::indexOf($plugin, 'appui-') === 0) {
        $plugin = Str::sub($plugin, 6);
      }
      */
    }
    elseif (!($res = $model->getPluginModel($code, $model->data, $model->pluginUrl('appui-dashboard'), $info['cache'] ?? 0))) {
      if (!empty($info['cache'])) {
        $res = $model->getCachedModel(APPUI_DASHBOARD_ROOT."/data/$code", $info['cache']);
      }
      else {
        $res = $model->getModel(APPUI_DASHBOARD_ROOT."/data/$code");
      }
    }

    $model->timer->stop('lastPart');
    $model->timer->stop('global');
    if (is_array($res)) {
      if (X::isAssoc($res)) {
        $res['success'] = true;
        foreach ($res as $k => $r) {
          $res[$k] = $r;
        }
        $res['timing'] = $model->timer->results();
      }
      else {
        $res = [
          'success' => true,
          'data'  => $res,
          'timing' => $model->timer->results(),
          'total' => count($res)
        ];
      }
    }
  }
}

return $res;
