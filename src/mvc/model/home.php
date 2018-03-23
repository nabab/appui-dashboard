<?php
/** @var \bbn\mvc\model $model */
$id_widgets = $model->inc->options->from_code('widgets', 'dashboard', 'appui');
$id_perm_widgets = $model->inc->options->from_code('widgets', $model->inc->perm->get_current());
$widgets_perms = (array)$model->inc->perm->get_all($id_perm_widgets);
$widgets = array_filter($model->inc->options->full_options($id_widgets), function($w) use($widgets_perms){
  return \bbn\x::find($widgets_perms, ['id' => $w['id_alias']]) !== false;
});
$widgets = \bbn\x::merge_arrays($widgets, array_map(function($w){
  return \bbn\x::merge_arrays($w['widget'], [
    'id' => $w['id'],
    'text' => $w['text'],
    'num' => $w['num']
  ]);
}, $model->inc->pref->get_all($id_widgets)));

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
//$obs = new \bbn\appui\observer($model->db);
$no_cache = ['consultations', 'bugs', 'users', 'dossiers', 'news'];
$i = 0;
foreach ( $widgets as $i => $w ){
  if ( !empty($w['code']) ){
    $w['url'] = $model->plugin_url().'/data/'.$w['code'];
  }
  $w['key'] = $w['id'];
  unset($w['id_alias'], $w['code'], $w['num_children'], $w['id'], $w['id_parent']);
  //unset($w['id_alias'], $w['code'], $w['num'], $w['num_children'], $w['id'], $w['id_parent']);
  $r[$i] = $w;
  /*
  $cn = './widgets/'.$w['code'];
  if ( !\in_array($code, $no_cache) ){
    $r['data'][$code]['items'] = $model->get_cached_model($cn, $id);
  }
  else{
    $r['data'][$code]['items'] = $model->get_model($cn, $id);
  }
  if ( !\is_array(($r['data'][$i]['items'] = $model->get_plugin_model($w['code']))) ){
    $r['data'][$i]['items'] = [];
  }
  $r['data'][$i]['num'] = \count($r['data'][$i]['items']) ?: false;
  $obs->register($r['data'][$i], $w['code'], 'home');
  */
}
return [
  'data' => $r
];