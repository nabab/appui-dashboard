<?php
if ($all = $model->inc->options->fullTreeRef('widgets', 'dashboard', 'appui')) {
  return [
    'data' => empty($all) ? [] : $all['items']
  ];
}
return ['data' => []];