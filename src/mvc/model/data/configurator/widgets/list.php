<?php
$opts = !empty($model->data['data']['id'])
  ? $model->inc->options->fullOptionsRef($model->data['data']['id'])
  : $model->inc->options->fullOptionsRef('widgets', 'dashboard', 'appui');
return [
  'data' => $opts,
  'total' => count($opts)
];