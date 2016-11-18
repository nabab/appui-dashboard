<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
return array_map(function($a){
  if ( substr($a['last_connection'], 0, 10) === strftime('%Y-%m-%d') ){
    if ( ( time() - strtotime($a['last_connection']) ) < 1200 ){
      $a['last_connection'] = 'En ligne';
    }
    else{
      $a['last_connection'] = substr($a['last_connection'], 11, 5);
    }
  }
  else{
    $a['last_connection'] = date('d/m', strtotime($a['last_connection']));
  }
  return $a;
}, $model->db->get_rows("
  SELECT MAX(apst_users_sessions.last_activity) AS last_connection, apst_users.nom
  FROM apst_users_sessions
    JOIN apst_users
      ON apst_users.id = apst_users_sessions.id_user
  WHERE last_activity > NOW( ) - INTERVAL 7 DAY
  GROUP BY apst_users_sessions.id_user
  ORDER BY last_connection DESC LIMIT $limit"));