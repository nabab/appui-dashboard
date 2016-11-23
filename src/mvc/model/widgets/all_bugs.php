<?php
/** @var $model \bbn\mvc\model */

return array_map(function($a){
  $a['bugclass'] = \bbn\str::encode_filename($a['status']);
  return $a;
}, $model->db->get_rows("
  SELECT bbn_tasks.id, title, bbn_options.code AS status,
  FROM_UNIXTIME(MAX(bbn_tasks_logs.chrono), '%Y-%m-%d %H:%i:%s') AS last_activity
  FROM bbn_tasks
    JOIN bbn_tasks_logs
      ON bbn_tasks.id = bbn_tasks_logs.id_task
    JOIN bbn_options
      ON bbn_tasks.state = bbn_options.id
  WHERE state != 2023954527
  GROUP BY bbn_tasks.id
  ORDER BY last_activity DESC
  LIMIT ".
      (isset($model->data['limit']) && \bbn\str::is_integer($model->data['limit']) ? $model->data['limit'] : 5)));