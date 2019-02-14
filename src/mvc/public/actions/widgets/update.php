<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
$ctrl->obj->success = false;
if ( isset($ctrl->post['text'], $ctrl->post['id']) ){
  $cfg = $ctrl->inc->options->get_parent_cfg($ctrl->post['id']);
  if ( !empty($cfg['schema']) && ($schema = json_decode($cfg['schema'], true)) ){
    foreach ( $ctrl->post as $i => $d ){
      if (
        (($idx = \bbn\x::find($schema, ['field' => $i])) !== false) &&
        isset($schema[$idx]['type']) &&
        (strtolower($schema[$idx]['type']) === 'json')
      ){
        $ctrl->post[$i] = json_decode($d, true);
      }
    }
  }

  if ( $ctrl->inc->options->set($ctrl->post['id'], $ctrl->post) ){
    $ctrl->obj->success = true;
    //$ctrl->obj->data = \bbn\x::merge_arrays($ctrl->inc->options->native_option($ctrl->post['id']), $ctrl->inc->options->option($ctrl->post['id']));
    $ctrl->obj->data = $ctrl->inc->options->native_option($ctrl->post['id']);
  }
}
