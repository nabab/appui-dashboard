<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var bbn\Mvc\Controller $ctrl */
$ctrl->obj->success = false;
if ( isset($ctrl->post['text'], $ctrl->post['id']) ){
  $cfg = $ctrl->inc->options->getParentCfg($ctrl->post['id']);
  if ( !empty($cfg['schema']) && ($schema = json_decode($cfg['schema'], true)) ){
    foreach ( $ctrl->post as $i => $d ){
      if (
        (($idx = \bbn\X::find($schema, ['field' => $i])) !== null) &&
        isset($schema[$idx]['type']) &&
        (strtolower($schema[$idx]['type']) === 'json')
      ){
        $ctrl->post[$i] = json_decode($d, true);
      }
    }
  }

  if ( $ctrl->inc->options->set($ctrl->post['id'], $ctrl->post) ){
    $ctrl->obj->success = true;
    //$ctrl->obj->data = \bbn\X::mergeArrays($ctrl->inc->options->nativeOption($ctrl->post['id']), $ctrl->inc->options->option($ctrl->post['id']));
    $ctrl->obj->data = $ctrl->inc->options->nativeOption($ctrl->post['id']);
  }
}
