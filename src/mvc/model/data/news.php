<?php
/** @var $model \bbn\mvc\model */
$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
$start = isset($model->data['start']) && is_int($model->data['start']) ? $model->data['start'] : 0;
$type_note = $model->inc->options->from_code('news', 'types', 'notes', 'appui');
$type_event = $model->inc->options->from_code('NEWS', 'evenements');

$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => 'bbn_notes',
  'fields' => [
    'versions1.id_note',
    'versions1.version',
    'versions1.title',
    'versions1.content',
    'versions1.id_user',
    'versions1.creation',
    'bbn_events.start',
    'bbn_events.end'
  ],
  'join' => [[
    'table' => 'bbn_notes_events',
    'on' => [
      'conditions' => [[
        'field' =>  'bbn_notes_events.id_note',
        'operator' => '=',
        'exp' => 'bbn_notes.id'
      ]]
    ]
  ], [
    'table' => 'bbn_events',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_events.id_type',
        'value' => $model->inc->options->from_code('NEWS', 'evenements')
      ], [
        'field' => 'bbn_events.id',
        'exp' => 'bbn_notes_events.id_event'
      ], [
        'field' => 'bbn_events.start',
        'operator' => '<=',
        'exp' => 'NOW()'
      ], [
        'logic' => 'OR',
        'conditions' => [[
          'field' => 'bbn_events.end',
          'operator' => '>=',
          'exp' => 'NOW()'
        ], [
          'field' => 'bbn_events.end',
          'operator' => 'isnull'
        ]]
      ]]
    ]
  ], [
    'table' => 'bbn_notes_versions',
    'type' => 'left',
    'alias' => 'versions1',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_notes.id',
        'exp' => 'versions1.id_note'
      ]]
    ]
  ], [
    'table' => 'bbn_notes_versions',
    'type' => 'left',
    'alias' => 'versions2',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_notes.id',
        'exp' => 'versions2.id_note'
      ], [
        'field' => 'versions1.version',
        'operator' => '<',
        'exp' => 'versions2.version'
      ]]
    ]
  ]],
  'where' => [
    'conditions' => [[
      'field' => 'bbn_notes.id_type',
      'value' => $type_note
    ], [
      'field' => 'bbn_notes.active',
      'value' => 1
    ], [
      'field' => 'versions2.version',
      'operator' => 'isnull'
    ]]
  ],
  'group_by' => 'bbn_notes.id',
  'order' => [[
    'field' => 'versions1.version',
    'dir' => 'DESC'
  ], [
    'field' => 'versions1.creation',
    'dir' => 'DESC'
  ]],
  'limit' => $limit,
  'start' => $start,
  'observer' => [
    'request' => "
      SELECT MAX(creation)
      FROM bbn_notes_versions
      JOIN bbn_notes
        ON bbn_notes_versions.id_note = bbn_notes.id
        AND bbn_notes.active = 1
      WHERE bbn_notes.id_type = ?
      LIMIT 1",
    'params' => [$type_note],
    'public' => true,
    'name' => _('News')
  ]
]);
if ( $grid->check() ){
  $d = $grid->get_datatable();
  if ( isset($d['data']) ){
    $d['items'] = $d['data'];
    unset($d['data']);
  }
  $d['id_type'] = $model->inc->options->from_code('news', 'types', 'notes', 'appui');
  return $d;
}
return [];