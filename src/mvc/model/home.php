<?php
/** @var \bbn\mvc\model $model */
// Getting the ID of the widgets' root in the options
$id_widgets = $model->inc->options->from_code('widgets', 'dashboard', 'appui');
// Getting the ID of the widgets' root permission in the options based on the current controller
$id_perm_widgets = $model->inc->options->from_code('widgets', $model->inc->perm->get_current());
// Getting all the widgets' permissions for the current user
if (!is_array($widgets_perms = $model->inc->perm->full_options($id_perm_widgets))) {
  $widgets_perms = [];
}
// All the widgets infos comes from the options
$tmp = $model->inc->options->full_options($id_widgets);
// Except if the user is an admin, the widget array will only contain
// what he has permission for or what is public
$widgets = $model->inc->user->is_admin() ? $tmp : array_filter($tmp, function($w) use($widgets_perms){
  return !empty($w['alias']['public']) || \bbn\x::find($widgets_perms, ['id_option' => $w['id_alias']]) !== false;
});
foreach ($widgets as &$w) {

}

// the final widget array will be merged with the preferences of the user for each widget
//die(\bbn\x::dump($widgets, $model->inc->pref->get_all($id_widgets)));
$widgets = \bbn\x::merge_arrays(
  array_map(function($w) use($model){
    if ( $pref_cfg = $model->inc->pref->get_cfg_by_option($w['id']) ){
      $w = \bbn\x::merge_arrays($w, $pref_cfg);
    }
    if ( ($pref = $model->inc->pref->get_by_option($w['id'])) && isset($pref['num']) ){
      $w['num'] = $pref['num'];
    }
    $w['index'] = $w['num'];
    return $w;
  }, $widgets), 
  array_map(function($w){
    return \bbn\x::merge_arrays($w['widget'], [
      'id' => $w['id'],
      'text' => $w['text'],
      'index' => $w['num'],
      'hidden' => !empty($w['hidden'])
    ]);
  }, $model->inc->pref->get_all($id_widgets))
);

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