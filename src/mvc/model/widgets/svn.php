<?php
$limit = isset($model->data['limit']) && \bbn\str::is_integer($model->data['limit']) ? $model->data['limit'] : 5;
return [
  [
    'title' => 'Application',
    'revisions' => $model->db->rselect_all('apst_svn', [], ['repo' => 'app'], ['revision' => 'DESC'], $limit)
  ], [
    'title' => 'Contenu statique',
    'revisions' => $model->db->rselect_all('apst_svn', [], ['repo' => 'cdn'], ['revision' => 'DESC'], $limit),
  ], [
    'title' => 'Site Web',
    'revisions' => $model->db->rselect_all('apst_svn', [], ['repo' => 'web'], ['revision' => 'DESC'], $limit),
  ]
];