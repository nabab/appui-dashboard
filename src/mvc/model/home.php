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
  $r['data'][$i] = $w;
  if ( !empty($o['limit']) ){
    $r['data'][$i]['limit'] = $o['limit'];
  }
  /*
  $cn = './widgets/'.$w['code'];
  if ( !in_array($code, $no_cache) ){
    $r['data'][$code]['items'] = $model->get_cached_model($cn, $id);
  }
  else{
    $r['data'][$code]['items'] = $model->get_model($cn, $id);
  }
  */
  if ( !is_array(($r['data'][$i]['items'] = $model->get_plugin_model($w['code']))) ){
    $r['data'][$i]['items'] = [];
  }
  $r['data'][$i]['num'] = count($r['data'][$i]['items']) ?: false;
  $obs->register($r['data'][$i], $w['code'], 'home');
}
return ['data' => $r];
