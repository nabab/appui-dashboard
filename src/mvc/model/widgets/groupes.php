<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
return $model->db->get_rows("
  SELECT DISTINCT(line), apst_adherents.id, nom, statut, statut_prospect
  FROM bbn_history
    JOIN apst_adherents
      ON apst_adherents.id = line
      AND apst_adherents.statut = 'groupe'
      AND apst_adherents.actif = 1
      AND apst_adherents.test = 0
  WHERE `column` LIKE '{$model->db->current}.apst_adherents.id'
  AND `operation` LIKE 'INSERT'
  ORDER BY chrono DESC LIMIT $limit");
