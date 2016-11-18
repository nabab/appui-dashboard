<?php
/** @var $model \bbn\mvc\model */
$data = [
  [
    'titre' => "Adhérents",
    'val' => $model->db->get_var("SELECT COUNT(id) FROM apst_adherents WHERE statut LIKE 'adherent' AND test = 0 AND actif = 1")
  ], [
    'titre' => "Prospects actifs",
    'val' => $model->db->get_var("SELECT COUNT(id) FROM apst_adherents WHERE statut LIKE 'prospect' AND test = 0 AND actif = 1 AND statut_prospect != 832060390 AND statut_prospect != 640802273 AND statut_prospect != 1884557545")
  ], [
    'titre' => "Cotisations appelées",
    'val' => $model->db->get_var("
    	SELECT SUM(cotis_appelee) FROM apst_adherents WHERE test = 0 AND actif = 1")
  ], [
    'titre' => "Cotisations calculées",
    'val' => $model->db->get_var("
    	SELECT SUM(cotis_calculee) FROM apst_adherents WHERE test = 0 AND actif = 1")
  ], [
    'titre' => "Adhérents à la note inférieure à 10",
    'val' => $model->db->get_var("SELECT COUNT(id) FROM apst_adherents WHERE statut LIKE 'adherent' AND note_interne < 10 AND test = 0 AND actif = 1")
  ], [
    'titre' => "Adhérents sous surveillance",
    'val' => $model->db->get_var("SELECT COUNT(id) FROM apst_adherents WHERE statut LIKE 'adherent' AND surveillance = 1 AND test = 0 AND actif = 1")
  ], [
    'titre' => "Adhérents insolvables",
    'val' => $model->db->get_var("SELECT COUNT(id) FROM apst_adherents WHERE statut LIKE 'adherent' AND alerte_ratio = 1 AND test = 0 AND actif = 1")
  ], [
    'titre' => "Total garanti",
    'val' => $model->db->get_var("SELECT SUM(garantie_apst) FROM apst_adherents WHERE statut LIKE 'adherent' AND test = 0 AND actif = 1")
  ]
];
return \bbn\x::merge_arrays($data, $model->db->rselect_all('apst_stats', [
  'nom',
  'titre',
  'val' => 'res'
], [
  ['res', 'NOT LIKE', '[%'],
  ['widget', '=', 1]
], ['id']));
