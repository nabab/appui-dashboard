<?php
/** @var \bbn\mvc\model $model */
$widgets = $model->inc->pref->get_existing_permissions('home/widgets');
$r = [
  'widgets' => [],
  'data' => []
];
$obs = new \bbn\appui\observer($model->db);
$no_cache = ['consultations', 'bugs', 'stats', 'users', 'dossiers'];
foreach ( $widgets as $id => $code ){
  if ( $model->inc->pref->has_permission($id) ){
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
    if ( !in_array($code, $no_cache) ){
      $r['data'][$code]['items'] = $model->get_cached_model($cn, $wid);
    }
    else{
      $r['data'][$code]['items'] = $model->get_model($cn, $wid);
    }
    if ( !is_array($r['data'][$code]['items']) ){
      $r['data'][$code] = ['items' => []];
    }
    $r['data'][$code]['num'] = count($r['data'][$code]['items']) ?: false;
    $obs->register($r['data'][$code], $code, 'home');
  }
}
return $r;
