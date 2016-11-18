<?php
/** @var $model \bbn\mvc\model */
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
return $model->db->get_rows("
  SELECT apst_consultations.id_adherent AS id, apst_adherents.nom, statut_prospect,
  apst_adherents.statut, SUM(apst_consultations.nb) AS num
  FROM apst_consultations
    JOIN apst_adherents
      ON apst_adherents.id = apst_consultations.id_adherent
      AND apst_adherents.actif = 1
      AND apst_adherents.test = 0
  GROUP BY apst_consultations.id_adherent
  ORDER BY num DESC
  LIMIT $limit");