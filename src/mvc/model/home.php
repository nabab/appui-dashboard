<?php
/** @var \bbn\mvc\model $model */
$widgets = (array)$model->inc->perm->get('home/widgets');
$r = [
  'widgets' => [],
  'data' => []
];
$obs = new \bbn\appui\observer($model->db);
$no_cache = ['consultations', 'bugs', 'stats', 'users', 'dossiers'];
foreach ( $widgets as $id => $code ){
  $o = $model->inc->options->option($id);
  $cn = './widgets/'.$code;
  $r['data'][$code] = [
    'text' => $o['text'],
    'link' => $code,
    'template' => !empty($o['template']) ? $o['template'] : 'adh',
  ];
  if ( !empty($o['limit']) ){
    $r['data'][$code]['limit'] = $o['limit'];
  }
  /*
  if ( !in_array($code, $no_cache) ){
    $r['data'][$code]['items'] = $model->get_cached_model($cn, $id);
  }
  else{
    $r['data'][$code]['items'] = $model->get_model($cn, $id);
  }
  */
  $r['data'][$code]['items'] = $model->get_plugin_model($code);
  if ( !is_array($r['data'][$code]['items']) ){
    $r['data'][$code] = ['items' => []];
  }
  $r['data'][$code]['num'] = count($r['data'][$code]['items']) ?: false;
  $obs->register($r['data'][$code], $code, 'home');
}
//die(var_dump($widgets, $r));
return $r;
