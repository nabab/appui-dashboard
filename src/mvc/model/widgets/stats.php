<?php

$id_stats = range(18, 33);
$ids_types = [
  'd' => [18,22,26,30],
  'w' => [19,23,27,31],
  'm' => [20,24,28,32],
  'y' => [21,25,29,33]
];
$keys = $model->db->select_all_by_keys('apst_stats', ['nom', 'id', 'titre']);
$charts = [];

// Either send the stat type, or determine it if in the session, or use the default one
if ( !isset($model->data['type']) && isset($model->inc->session) ){
  $model->data['type'] = $model->inc->session->get('stats', 'type');
}
if ( empty($model->data['type']) ){
  // Default chart
  $model->data['type'] = 'num_docs_deposes_d';
}
else if ( isset($model->inc->session) ) {
  $model->inc->session->set($model->data['type'], 'stats', 'type');
}
if ( isset($model->data['type']) && is_array($keys[$model->data['type']]) ){
// The selected stat type
  $id =  $keys[$model->data['type']]['id'];


  $cont = 0;
  $loop = false;
  $time = time();
  $data = [];

  foreach ( $ids_types as $te => $i ){
    if ( in_array($id, $i) ){
      $loop = $te;
    }

  }

  $max = \bbn\appui\history::get_val_back('apst_stats', 'res', ['id' => $id], $time);
  array_push($data, [
    'date' => date('d/m/y', $time),
    'val' => $max
  ]);

  while ( $cont < 19 ){
    if ( !empty($loop) ){
      switch ($loop){
        case 'd':
          $time = mktime(23,59,59,date('m', $time),date('d',$time)-1,date('Y', $time));
          break;
        case 'w':
          $sunday = strtotime("last Sunday", $time);
          $time = mktime(23,59,59,date('m', $sunday),date('d', $sunday),date('Y', $sunday));
          break;
        case 'm':
          $month_prev = mktime(23,59,59,date('m', $time)-1,1,date('Y', $time));
          $time = mktime(23,59,59,date('m', $month_prev),date('t',$month_prev),date('Y', $month_prev));
          break;
        case 'y':
          $time = mktime(23,59,59,12,31,date('Y', $time)-1);
          break;
      }
      if ( ($loop === 'y') && ((int)date('Y', $time) < 2014) ){
        break;
      }
    }

    //$val = \bbn\appui\history::get_val_back('apst_stats', 'res', ['id' => $id], $time);
    $val = \bbn\appui\history::get_next_update('apst_stats', $time, $id, 'res')['old'];
    $max = $val > $max ? $val : $max;
    array_unshift($data, [
      'date' => date('d/m/y', $time),
      'val' => $val
    ]);
    $cont++;
  }

  foreach ( $keys as $i => $key ){
    if ( in_array($key['id'], $id_stats) ){
      array_push($charts, [
        'text' => $key['titre'],
        'value' => $i
      ]);
    }
  }

  return [
    'data' => $data,
    'title' => $keys[$model->data['type']]['titre'],
    'charts' => $charts,
    'value' => $model->data['type'],
    'mu' => $max > 10 ? 'undefined' : 1
  ];
}
