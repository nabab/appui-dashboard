<?php
/** @var $model \bbn\mvc\model */

$limit = isset($model->data['limit']) && is_int($model->data['limit']) ? $model->data['limit'] : 5;
$start = isset($model->data['start']) && is_int($model->data['start']) ? $model->data['start'] : 0;
$type = $model->inc->options->from_code('personal', 'types', 'notes', 'appui');
$note = new \bbn\appui\notes($model->db);
$obs = new bbn\appui\observer($model->db);
$res = [
  'id_type' => $type,
  'items' => $note->get_by_type($type, $model->inc->user->get_id(), $limit, $start),
  'limit' => $limit,
  'start' => $start,
  'total' => $note->count_by_type($type, $model->inc->user->get_id())
];
if ( $id_obs = $obs->add([
  'request' => "
    SELECT MAX(creation)
    FROM bbn_notes_versions
    JOIN bbn_notes
      ON bbn_notes_versions.id_note = bbn_notes.id
      AND bbn_notes.active = 1
    WHERE bbn_notes.id_type = ?
      AND bbn_notes.creator = ?
    LIMIT 1",
  'params' => [$type, $model->inc->user->get_id()],
  'public' => false,
  'name' => _('Personal notes')
]) ){
  $res['observer'] = [
    'id' => $id_obs,
    'value' => $obs->get_result($id_obs)
  ];
}

return $res;
