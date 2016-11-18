<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;

return $model->db->rselect_all('apst_news', ['id', 'titre', 'auteur'], [
  ['debut', '<=', date('Y-m-d')],
  ['fin', '>', date('Y-m-d')],
  ['actif', '=', 1]
], ['debut' => 'desc', 'id' => 'desc'], $limit);
