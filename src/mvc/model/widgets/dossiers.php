<?php
/** @var $model \bbn\mvc\model */

return array_map(function($a){
  $a['bugclass'] = \bbn\str::encode_filename($a['status']);
  return $a;
}, $model->db->get_rows("
  SELECT apst_adherents.id, nom, statut, 
  title, bbn_options.code AS status, MIN(priority) AS priority, MIN(deadline) AS deadline,
  FROM_UNIXTIME(MAX(bbn_tasks_logs.chrono), '%Y-%m-%d %H:%i:%s') AS last_activity,
  id_adherent
  FROM bbn_tasks
    JOIN bbn_tasks_roles
      ON bbn_tasks.id = bbn_tasks_roles.id_task
    JOIN bbn_tasks_logs
      ON bbn_tasks.id = bbn_tasks_logs.id_task
    JOIN bbn_options
      ON bbn_tasks.state = bbn_options.id
    JOIN apst_adherents_task_links
      ON bbn_tasks.id = apst_adherents_task_links.id_task
    JOIN apst_adherents
      ON apst_adherents.id = apst_adherents_task_links.id_adherent
  WHERE bbn_tasks_roles.id_user = ?
  AND state != 2023954527
  GROUP BY apst_adherents.id
  ORDER BY last_activity DESC
  LIMIT ".
  (isset($model->data['limit']) && \bbn\str::is_integer($model->data['limit']) ? $model->data['limit'] : 5),
  $model->inc->user->get_id()));