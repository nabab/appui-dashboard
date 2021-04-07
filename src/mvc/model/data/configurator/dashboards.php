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
    $pFields['text'] => 'IFNULL(' . $model->db->cfn($pFields['text'], 'uo') . ',' . $model->db->cfn($pFields['text'], $pTable) . ')',
    $model->db->cfn($pFields['cfg'], $pTable),
    'code' => 'IFNULL(' . $model->db->cfn($pFields['cfg'], 'uo') . '->>"$.code"' . ','. $model->db->cfn($pFields['cfg'], $pTable) . '->>"$.code"' . ')'
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