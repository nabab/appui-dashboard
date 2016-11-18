<?php
$u = $model->inc->user->get_id();
$res = [];
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
return $model->db->get_rows("
  SELECT id_adherent AS id, nom, statut, statut_prospect
  FROM apst_consultations
    JOIN apst_adherents
      ON apst_adherents.id = apst_consultations.id_adherent
      AND apst_adherents.actif = 1
      AND apst_adherents.test = 0
  WHERE apst_consultations.id_user = ?
  ORDER BY apst_consultations.last_time DESC
  LIMIT $limit",
  $u);
