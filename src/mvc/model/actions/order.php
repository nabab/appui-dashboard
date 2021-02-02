<?php
/**
 * @var bbn\Mvc\Model $model
 */

/* 
$res = ['success' => false];
if ( isset($model->data['order']) && is_array($model->data['order']) && defined('BBN_REFERER') ){
  if (
    ($route = $ctrl->getRoute(BBN_REFERER, 'public')) &&
    ($id_perm = $ctrl->inc->perm->fromPath($route['path']))
  ){
    if ( !$model->inc->pref->userHas($id_perm) ){
      $model->inc->pref->add($id_perm, []);
    }
    $pref = $model->inc->pref->getByOption($id_perm);
    if ( $pref ){
      $i = 0;
      $res['deleted'] = $model->inc->pref->deleteBits($pref['id']);
      foreach ( $model->data['order'] as $i => $id ){
        $i += (int)$model->inc->pref->addBit($pref['id'], [
          'id_option' => $id,
          'num' => $i + 1
        ]);
      }
      if ( $i ){
        $res['success'] = true;
        $res['num'] = $i;
      }
    }
  }
}
return $res;
 */

if ( isset($model->data['order']) && is_array($model->data['order']) ){
  return ['success' => $model->inc->dashboard->sort($model->data['order'])];
}
return ['success' => false];