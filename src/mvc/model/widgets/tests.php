<?php
/** @var $model \bbn\mvc\model */
return $model->db->rselect_all('apst_adherents', [
    'id', 'nom', 'statut', 'statut_prospect'
  ], [
    'test' => 1
  ]);