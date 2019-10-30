<?php
/** @var \bbn\mvc\model $model */

$model->data['limit'] = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
$model->data['start'] = isset($model->data['start']) && is_int($model->data['start']) ? $model->data['start'] : 0;
$user_cfg = $model->inc->user->get_class_cfg();
$grid = new \bbn\appui\grid($model->db, $model->data, [
  'tables' => [$user_cfg['tables']['sessions']],
  'fields' => [
    'last_connection' => 'MAX('.$user_cfg['tables']['sessions'].'.'.$user_cfg['arch']['sessions']['last_activity']. ')',
    $user_cfg['table'].'.'.$user_cfg['arch']['users']['username']
  ],
  'join' => [[
    'table' => $user_cfg['table'],
    'on' => [
      'conditions' => [[
        'field' => $user_cfg['table'].'.'.$user_cfg['arch']['users']['id'],
        'exp' => $user_cfg['tables']['sessions'].'.'.$user_cfg['arch']['sessions']['id_user']
      ]]
    ]
  ]],
  'order' => [[
    'field' => 'last_connection',
    'dir' => 'DESC'
  ]],
  'filters' => [[
    'field' => $user_cfg['arch']['sessions']['last_activity'],
    'operator' => 'gt',
    'exp' => '(NOW() - INTERVAL 7 DAY)'
  ]],
  'group_by' => $user_cfg['tables']['sessions'].'.'.$user_cfg['arch']['sessions']['id_user']
  /*,
  'observer' => [
    'request' => "
			SELECT id_user, MAX(bbn_users_sessions.last_activity) AS
      FROM bbn_users_sessions
      WHERE last_activity > (NOW() - INTERVAL 7 DAY)
      LIMIT 1",
    'name' => "Utilisateurs de l'application",
    'public' => true
  ]
*/
]);
if ($grid->check()) {
  $res = $grid->get_datatable();
  $res['data'] = array_map(function($a){
    if ( substr($a['last_connection'], 0, 10) === strftime('%Y-%m-%d') ){
      if ( ( time() - strtotime($a['last_connection']) ) < 1200 ){
        $a['last_connection'] = _('Online');
      }
      else{
        $a['last_connection'] = substr($a['last_connection'], 11, 5);
      }
    }
    else{
      $a['last_connection'] = date('d/m', strtotime($a['last_connection']));
    }
    return $a;
  }, $res['data']);
  return $res;
}