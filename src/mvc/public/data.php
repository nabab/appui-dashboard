<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 05/06/2017
 * Time: 16:20
 */
/** @var \bbn\mvc\controller $ctrl */
/** @var \bbn\user\permissions $ctrl->inc->perm */
$ctrl->obj->success = false;
if (
  !empty($ctrl->post['key']) &&
  (
    (
      ($id_perm = $ctrl->inc->options->get_prop($ctrl->post['key'], 'id_alias')) &&
      ($code = $ctrl->inc->options->code($id_perm)) &&
      $ctrl->inc->perm->has($id_perm)
    )  ||
    (
      ($pref = $ctrl->inc->pref->get($ctrl->post['key'])) &&
      ($code = $pref['widget']['code'])
    )
  )
){
/*if (
  isset($ctrl->post['key']) &&
  ($id_perm = $ctrl->inc->options->get_prop($ctrl->post['key'], 'id_alias')) &&
  ($code = $ctrl->inc->options->code($id_perm)) &&
  $ctrl->inc->perm->has($id_perm)
){*/
  $res = $ctrl->get_plugin_model($code, $ctrl->post);
  if ( \is_array($res) ){
    $ctrl->obj->success = true;
    if ( \bbn\x::is_assoc($res) ){
      foreach ($res as $k => $r ){
        $ctrl->obj->$k = $r;
      }
    }
    else{
      $ctrl->obj->data = $res;
      $ctrl->obj->total = \count($res);
    }
  }
}
