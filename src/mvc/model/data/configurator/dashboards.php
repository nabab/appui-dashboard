<?php
$uoCfg = $model->inc->pref->getClassCfg();
$pTable = $uoCfg['table'];
$pFields = $uoCfg['arch']['user_options'];
$bTable = $uoCfg['tables']['user_options_bits'];
$bFields = $uoCfg['arch']['user_options_bits'];
$grid = new \bbn\Appui\Grid($model->db, $model->data, [
  'table' => $pTable,
  'fields' => [
    $model->db->cfn($pFields['id'], $pTable),
    $model->db->cfn($pFields['id_user'], $pTable),
    $model->db->cfn($pFields['id_group'], $pTable),
    $model->db->cfn($pFields['id_alias'], $pTable),
    $model->db->cfn($pFields['public'], $pTable),
    $pFields['text'] => 'IFNULL(' . $model->db->cfn($pFields['text'], 'uo', true) . ',' . $model->db->cfn($pFields['text'], $pTable, true) . ')',
    $model->db->cfn($pFields['cfg'], $pTable),
    'code' => 'IFNULL(JSON_EXTRACT(' . $model->db->cfn($pFields['cfg'], 'uo', true) . ', "$.code")' . ', JSON_EXTRACT('. $model->db->cfn($pFields['cfg'], $pTable, true) . ', "$.code"))'
  ],
  'join' => [[
    'table' => $pTable,
    'alias' => 'uo',
    'type' => 'left',
    'on' => [
      'conditions' => [[
        'field' => $model->db->cfn($pFields['id_alias'], $pTable),
        'exp' => $model->db->cfn($pFields['id'], 'uo')
      ]]
    ]
  ]],
  'filters' => [
    'conditions' => [[
      'field' => $model->db->cfn($pFields['id_option'], $pTable),
      'value'=> $model->inc->options->fromCode('list', 'dashboard', 'appui')
    ], [
      'logic' => 'OR',
      'conditions' => [[
        'field' => $model->db->cfn($pFields['public'], $pTable),
        'value' => 1
      ], [
        'field' => $model->db->cfn($pFields['id_user'], $pTable),
        'value' => $model->inc->user->getId()
      ], [
        'field' => $model->db->cfn($pFields['id_group'], $pTable),
        'value' => $model->inc->user->getGroup()
      ]]
    ]]
  ],
  'order' => [[
    'field' => $model->db->cfn($pFields['public'], $pTable),
    'dir' => 'desc'
  ], [
    'field' => $model->db->cfn($pFields['text'], $pTable),
    'dir' => 'asc'
  ]],
  'group_by' => [$model->db->cfn($pFields['id'], $pTable)]
]);

if ($grid->check()) {
  return $grid->getDatatable();
}