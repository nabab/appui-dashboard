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
$model->timer->start('widgetOption');
if ($model->hasData('key', true)
  && $dash
  && ($idWidget = $dash->getWidgetOption($model->data['key']) ?: $model->data['key'])
) {
  unset($model->data['key']);
  $res = $dash->getWidgetData($idWidget, $model, $model->data, $model->inc->perm);
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

return $res;
