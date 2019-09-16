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

if ( !empty($ctrl->post['key']) ){
  // Fetch the permission's alias: widget in dashboard options
  if ( $info = $ctrl->inc->options->option($ctrl->post['key']) ){
    $id_perm = $info['id_alias'];
    $code = $info['code'];
    if ( $pref = $ctrl->inc->pref->get_by_option($ctrl->post['key']) ){
      $info = \bbn\x::merge_arrays($info, $pref);
    }
  }
  // Otherwise checking if the key is a preference
  else if ( $info = $ctrl->inc->pref->get($ctrl->post['key']) ){
    $id_perm = $info['id_option'];
    $code = $info['widget']['code'];
  }
  if ( $code && $ctrl->inc->perm->has($id_perm) ){
    //die(var_dump($id_perm, $code, $info));
  /*if (
    isset($ctrl->post['key']) &&
    ($id_perm = $ctrl->inc->options->get_prop($ctrl->post['key'], 'id_alias')) &&
    ($code = $ctrl->inc->options->code($id_perm)) &&
    $ctrl->inc->perm->has($id_perm)
  ){*/
    if ( !$res = $ctrl->get_plugin_model($code, $ctrl->post, $info['cache'] ?? 0) ){
      if ( $info['cache'] ){
        $res = $ctrl->get_cached_model(APPUI_DASHBOARD_ROOT."/data/$code");
      }
      else{
        $res = $ctrl->get_model(APPUI_DASHBOARD_ROOT."/data/$code");
      }
    };
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
}
