<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var bbn\Mvc\Controller $ctrl */
$ctrl->obj->success = false;
if ( isset($ctrl->post['id_parent']) ){
  die(var_dump($ctrl->post['id_parent']));
  if ( !empty($ctrl->post['source_children']) ){
    $tree = $ctrl->inc->options->fullTree($ctrl->post['source_children']);
    if ( isset($tree['items']) ){
      $ctrl->post['items'] = $tree['items'];
    }
    unset($ctrl->post['source_children']);
  }
  
  $cfg = $ctrl->inc->options->getCfg($ctrl->post['id_parent']);
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
  
  if ( $id = $ctrl->inc->options->add($ctrl->post) ){
    $ctrl->obj->success = true;
    $ctrl->obj->data = $ctrl->inc->options->nativeOption($id);
  }
}