<?php
/** @var \bbn\mvc\model $model */
$widgets = (array)$model->inc->perm->get('home/widgets');
$r = [
  'data' => []
];
$obs = new \bbn\appui\observer($model->db);
$no_cache = ['consultations', 'bugs', 'stats', 'users', 'dossiers', 'news'];
$i = 0;
foreach ( $widgets as $i => $w ){
  if ( empty($w['template']) ){
    $w['template'] = 'adh';
  }
  if ( !empty($w['code']) ){
    $w['url'] = $model->plugin_url().'/data/'.$w['code'];
  }
  $w['key'] = $w['id'];
  unset($w['id_alias'], $w['code'], $w['num'], $w['num_children'], $w['id'], $w['id_parent']);
  $r['data'][$i] = $w;
  /*
  $cn = './widgets/'.$w['code'];
  if ( !in_array($code, $no_cache) ){
    $r['data'][$code]['items'] = $model->get_cached_model($cn, $id);
  }
  else{
    $r['data'][$code]['items'] = $model->get_model($cn, $id);
  }
  if ( !is_array(($r['data'][$i]['items'] = $model->get_plugin_model($w['code']))) ){
    $r['data'][$i]['items'] = [];
  }
  $r['data'][$i]['num'] = count($r['data'][$i]['items']) ?: false;
  $obs->register($r['data'][$i], $w['code'], 'home');
  */
}
return ['data' => $r];
