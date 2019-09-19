<?php
/**
 * @var bbn\mvc\model $model
 */

/* 
$res = ['success' => false];
if ( isset($model->data['order']) && is_array($model->data['order']) && defined('BBN_REFERER') ){
  if (
    ($route = $ctrl->get_route(BBN_REFERER, 'public')) &&
    ($id_perm = $ctrl->inc->perm->from_path($route['path']))
  ){
    if ( !$model->inc->pref->user_has($id_perm) ){
      $model->inc->pref->add($id_perm, []);
    }
    $pref = $model->inc->pref->get_by_option($id_perm);
    if ( $pref ){
      $i = 0;
      $res['deleted'] = $model->inc->pref->delete_bits($pref['id']);
      foreach ( $model->data['order'] as $i => $id ){
        $i += (int)$model->inc->pref->add_bit($pref['id'], [
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