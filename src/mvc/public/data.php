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
  isset($ctrl->post['key']) &&
  ($id = $ctrl->post['key']) &&
  ($code = $ctrl->inc->options->code($id)) &&
  $ctrl->inc->perm->has($id)
){
  $res = $ctrl->get_plugin_model($code, $ctrl->post);
  if ( \is_array($res) ){
    $ctrl->obj->success = true;
    $ctrl->obj->data = [];
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
