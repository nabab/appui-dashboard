<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
return $model->db->get_rows("
  SELECT apst_adherents.id, nom, statut, statut_prospect
  FROM apst_adherents
  WHERE apst_adherents.statut = 'adherent'
  AND apst_adherents.actif = 1
  AND apst_adherents.test = 0
  ORDER BY date_adhesion DESC LIMIT $limit");
