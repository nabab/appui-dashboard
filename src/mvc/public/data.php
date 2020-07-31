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
    if (
      ($perm = $ctrl->inc->options->option($id_perm)) &&
      ($parent = $ctrl->inc->options->option($perm['id_parent'])) &&
      (strpos($parent['code'], 'appui-') === 0) &&
      ($parent = $ctrl->inc->options->option($parent['id_parent'])) &&
      ($parent['code'] === 'plugins') &&
      ($plugin = $ctrl->inc->options->code($parent['id_parent'])) &&
      ($plugin = $ctrl->plugin_name(substr($plugin, 0, strlen($plugin)-1)))
    ){
      $res = $ctrl->get_subplugin_model($code, $ctrl->post, $ctrl->plugin_url($plugin), 'appui-dashboard', $info['cache'] ?? 0);
    }
    else if (!($res = $ctrl->get_plugin_model($code, $ctrl->post, $ctrl->plugin_url('appui-dashboard'), $info['cache'] ?? 0))) {
      if ( !empty($info['cache']) ) {
        $res = $ctrl->get_cached_model(APPUI_DASHBOARD_ROOT."/data/$code", $info['cache']);
      }
      else {
        $res = $ctrl->get_model(APPUI_DASHBOARD_ROOT."/data/$code");
      }
    }
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
