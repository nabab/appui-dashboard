<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
return $model->db->get_rows("
  SELECT apst_adherents.id, nom, statut, date_radiation AS chrono, statut_prospect
  FROM apst_adherents
  WHERE apst_adherents.statut = 'radie'
  AND actif = 1
  AND test = 0
  ORDER BY chrono DESC LIMIT $limit");
