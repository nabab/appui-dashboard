<?php
/** @var \bbn\mvc\model $model */
$id_widgets = $model->inc->options->from_code('widgets', $model->inc->perm->get_current());
$widgets = (array)$model->inc->perm->get_all($id_widgets);
/*
$o = $model->inc->options->options($id_widgets);
$p = $model->inc->perm->options($id_widgets);
$option = $model->inc->perm->get($id_widgets);
$widgets2 = (array)$model->inc->perm->get_full($id_widgets);
die(\bbn\x::dump(
  $o, $p,
  $model->inc->perm->get_current(),
  $id_widgets,
  $option,
  '-------------------------------',
  $widgets,
  '-------------------------------',
  $widgets2
));
*/
$r = [];
$obs = new \bbn\appui\observer($model->db);
$no_cache = ['consultations', 'bugs', 'stats', 'users', 'dossiers', 'news'];
$i = 0;
foreach ( $widgets as $i => $w ){
  if ( empty($w['template']) ){
    $w['template'] = 'adh';
  }
  if ( !empty($w['code']) ){
    if ( $w['code'] === 'news' ){
      $id_news_widget = $w['id'];
    }
    $w['url'] = $model->plugin_url().'/data/'.$w['code'];
  }
  $w['key'] = $w['id'];
  unset($w['id_alias'], $w['code'], $w['num'], $w['num_children'], $w['id'], $w['id_parent']);
  $r[$i] = $w;
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
return [
  'id_news_widget' => $id_news_widget,
  'data' => $r
];