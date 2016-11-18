<?php
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
$r = [];
$i = 0;
$model->data = $model->db->get_rows("
  SELECT `chrono`, `line`, `id_user`
  FROM `bbn_history`
  WHERE `column` LIKE '{$model->db->current}.apst_notes.id'
    AND (
      `operation` = 'INSERT'
      OR `operation` = 'UPDATE'
    )
  ORDER BY `chrono` DESC LIMIT $i , $limit");
foreach ( $model->data as $d ){
  $d2 = $model->db->get_row("
    SELECT `apst_notes`.`texte`, `apst_notes`.`id_adherent`,
    `apst_adherents`.`nom`, `apst_adherents`.`statut`, statut_prospect
    FROM `apst_notes`
      JOIN `apst_adherents`
        ON `apst_adherents`.`id` = `apst_notes`.`id_adherent`
    WHERE `apst_notes`.`id` = ?",
    $d['line']);
  if ( !isset($r[$d2['id_adherent']]) ){
    $text = \bbn\str::cut(strip_tags($d2['texte']), 100);
    $r[$d2['id_adherent']] = [
      'chrono' => $d['chrono'],
      'texte' => $text,
      'id' => $d2['id_adherent'],
      'nom' => $d2['nom'],
      'statut' => $d2['statut'],
      'id_user' => $d['id_user'],
    ];
  }
  if ( $i >= $limit ){
    break;
  }
  $i++;
}
return array_values($r);