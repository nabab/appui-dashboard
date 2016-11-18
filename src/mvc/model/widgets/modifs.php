<?php
/**
 * @var $model \bbn\mvc\model
 */

$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 10;

//$his = [];
//$q = $model->db->query()
$his = array_map(function($a){
  //$o = array_slice(explode(".", $a['column']), -2);
  //$a['column'] = $o[1];
  //$a['table'] = $o[0];
  $a['table'] = "apst_adherents";
  return $a;
}, $model->db->get_rows("SELECT DISTINCT line
  FROM bbn_history
  WHERE `column` LIKE  ?
  AND operation LIKE  'update'
  ORDER BY chrono DESC
  LIMIT $limit",
  $model->db->current.'.apst_adherents.%'));
$r = [];

foreach ( $his as $i => $h ){
  switch ( $h['table'] )
  {
    case "apst_adherents":
      array_push($r, $model->db->get_row("
        SELECT 'Adhérent' AS `type`, line AS id, nom, id_user, statut, statut_prospect
        FROM bbn_history
          JOIN apst_adherents
            ON apst_adherents.id = line
        WHERE line = ?
        AND operation LIKE  'update'
        AND `column` LIKE  ?
        ORDER BY chrono DESC LIMIT 1",
        $h['line'],
        $model->db->current.'.apst_adherents.%'));
      break;
    /*
    case "apst_liens":
      $o = $model->db->get_row("
        SELECT apst_adherents.nom, id_adherent AS id
        FROM apst_tiers
          JOIN apst_adherents
            ON apst_adherents.id = apst_tiers.id_adherent
        WHERE apst_tiers.id = ?",
        $h['line']);
      array_push($r,[
          'type' => 'Personne',
          'id' => $o['id'],
          'nom' => $o['nom'],
          'utilisateur' => $h['utilisateur']
      ]);
      break;
    */
  }
}
return $r;