<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 05/06/2017
 * Time: 16:20
 */
/** @var \bbn\Mvc\Controller $ctrl */
/** @var \stdClass           $ctrl->obj */
$ctrl->obj->success = false;
if (!empty($ctrl->post['key'])
  && ($idWidget = $ctrl->inc->dashboard->getWidgetOption($ctrl->post['key']) ?: $ctrl->post['key'])
) {
  // Fetches the permission's alias: widget in dashboard options
  /** @var \bbn\User\options $ctrl->inc->options */
  if ($info = $ctrl->inc->options->option($idWidget)) {
    $id_perm = $info['id_alias'];
    $code    = $info['code'];
    if ($pref = $ctrl->inc->pref->getByOption($idWidget)) {
      $info = \bbn\X::mergeArrays($info, $pref);
    }
  }
  // Otherwise checking if the key is a preference
  elseif ($info = $ctrl->inc->pref->get($idWidget)) {
    $id_perm = $info['id_option'];
    $code    = $info['widget']['code'];
  }

  if ($code && $ctrl->inc->perm->has($id_perm)) {
    if (($perm = $ctrl->inc->options->option($id_perm))
        && ($parent = $ctrl->inc->options->option($perm['id_parent']))
        && (strpos($parent['code'], 'appui-') === 0)
        && ($parent = $ctrl->inc->options->option($parent['id_parent']))
        && ($parent['code'] === 'plugins')
        && ($plugin = $ctrl->inc->options->code($parent['id_parent']))
        && ($plugin = $ctrl->pluginName(substr($plugin, 0, strlen($plugin) - 1)))
    ) {
      $res = $ctrl->getSubpluginModel($code, $ctrl->post, $plugin, 'appui-dashboard', $info['cache'] ?? 0);
    }
    elseif (!($res = $ctrl->getPluginModel($code, $ctrl->post, $ctrl->pluginUrl('appui-dashboard'), $info['cache'] ?? 0))) {
      if (!empty($info['cache'])) {
        $res = $ctrl->getCachedModel(APPUI_DASHBOARD_ROOT."/data/$code", $info['cache']);
      }
      else {
        $res = $ctrl->getModel(APPUI_DASHBOARD_ROOT."/data/$code");
      }
    }

    if (\is_array($res)) {
      $ctrl->obj->success = true;
      if (\bbn\X::isAssoc($res)) {
        foreach ($res as $k => $r) {
          $ctrl->obj->$k = $r;
        }
      }
      else {
        $ctrl->obj->data  = $res;
        $ctrl->obj->total = \count($res);
      }
    }
  }
}
