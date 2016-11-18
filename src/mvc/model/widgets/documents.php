<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
$q = $model->db->query("
  SELECT DISTINCT apst_documents.id_adherent
  FROM apst_documents
    JOIN bbn_history
      ON bbn_history.line = apst_documents.id
      AND `column` LIKE 'apst_app.apst_documents.id'
      AND operation LIKE 'INSERT'
  WHERE traitement = 0
  AND actif = 1
  ORDER BY chrono DESC");
$res = [];
while ( ($d = $q->get_row()) && (count($res) < $limit) ){
  array_push($res, $model->db->rselect('apst_adherents', [
    'id', 'nom', 'statut', 'statut_prospect'
  ], [
    'id' => $d['id_adherent']]
  ));
}
return $res;