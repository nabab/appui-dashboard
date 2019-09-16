<?php
/**
 * @var bbn\mvc\model $model
 */

$res = ['success' => false];
if ( !empty($model->data['order']) && is_array($model->data['order']) ){
  $id_perm = $model->inc->perm->from_path(APPUI_DASHBOARD_ROOT.'home');
  if ( $id_perm ){
    if ( !$model->inc->pref->user_has($id_perm) ){
      $model->inc->pref->add($id_perm, []);
    }
    $pref = $model->inc->pref->get_by_option($id_perm);
    if ( $pref ){
      $i = 0;
      $model->inc->pref->delete_bits($pref['id']);
      foreach ( $model->data['order'] as $i => $id ){
        $i += (int)$model->inc->pref->add_bit($pref['id'], [
          'id_option' => $id,
          'id_user_option' => $pref['id'],
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