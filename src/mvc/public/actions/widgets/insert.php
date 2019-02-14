<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
$ctrl->obj->success = false;
if ( isset($ctrl->post['id_parent']) ){
  die(var_dump($ctrl->post['id_parent']));
  if ( !empty($ctrl->post['source_children']) ){
    $tree = $ctrl->inc->options->full_tree($ctrl->post['source_children']);
    if ( isset($tree['items']) ){
      $ctrl->post['items'] = $tree['items'];
    }
    unset($ctrl->post['source_children']);
  }
  
  $cfg = $ctrl->inc->options->get_cfg($ctrl->post['id_parent']);
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
  
  if ( $id = $ctrl->inc->options->add($ctrl->post) ){
    $ctrl->obj->success = true;
    $ctrl->obj->data = $ctrl->inc->options->native_option($id);
  }
}